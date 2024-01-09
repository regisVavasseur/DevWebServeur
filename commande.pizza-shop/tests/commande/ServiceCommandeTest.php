<?php

namespace pizzashop\tests\commande;

use Faker\Factory;
use Illuminate\Database\Capsule\Manager as DB;
use pizzashop\commande\domain\dto\commande\CommandeDTO;
use pizzashop\commande\domain\dto\item\ItemDTO;
use pizzashop\commande\domain\entities\catalogue\Produit;
use pizzashop\commande\domain\entities\catalogue\Taille;
use pizzashop\commande\domain\entities\commande\Commande;
use pizzashop\commande\domain\entities\commande\Item;
use pizzashop\commande\domain\service\catalogue\CatalogueService;
use pizzashop\commande\domain\service\commande\ServiceCommande;
use Ramsey\Uuid\Uuid;

class ServiceCommandeTest extends \PHPUnit\Framework\TestCase {

    private static $commandeIds = [];
    private static $serviceProduits;
    private static $serviceCommande;
    private static $faker;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbcom = __DIR__ . '/../../config/commande.db.ini';
        $dbcat = __DIR__ . '/../../config/catalog.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbcom), 'commande');
        $db->addConnection(parse_ini_file($dbcat), 'catalog');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::$serviceProduits = new CatalogueService();
        self::$serviceCommande = new ServiceCommande(self::$serviceProduits, new \Monolog\Logger('test'));
        self::$faker = Factory::create('fr_FR');
        self::fillDB();
    }

    public static function tearDownAfterClass(): void
    {
        self::cleanDB();
    }

    private static function cleanDB(){
        foreach (self::$commandeIds as $id) {
            Commande::find($id)->delete();
            foreach (Item::where('commande_id', $id)->get() as $item) {
                $item->delete();
            }
        }
    }

    private static function fillDB() {
        //Create 2 to 5 commandes DTO with faker
        //Create 1 to 5 items DTO for each commande DTO with faker
        //Use the service to create the commandes with creerCommande(CommandeDTO): CommandeDTO
        //Verify that the returned CommandeDTO is the same as the one created

        for ($i = 0; $i < self::$faker->numberBetween(2, 5); $i++) {
            $commandeDTO = new CommandeDTO(
                self::$faker->numberBetween(1, 2),
                self::$faker->email,
                []
            );

            for ($j = 0; $j < self::$faker->numberBetween(1, 5); $j++) {

                $Random_Produit = self::$serviceProduits->getProduit(
                    self::$faker->numberBetween(1, 10),
                );

                $commandeDTO->addItem(
                    new ItemDTO(
                        $Random_Produit->numero,
                        Taille::where('id', self::$faker->numberBetween(1, 2))->first()->id,
                        self::$faker->numberBetween(1, 5)
                    )
                );

            }

            $commandeDTO->calculerMontant();

            $commandeDTO_DBRESPONSE = self::$serviceCommande->creerCommande($commandeDTO);

            self::$commandeIds[] = $commandeDTO_DBRESPONSE->getId();

            self::assertEquals(
                $commandeDTO->getTypeLivraison(), $commandeDTO_DBRESPONSE->getTypeLivraison()
            );

            self::assertEquals(
                $commandeDTO->getMailClient(), $commandeDTO_DBRESPONSE->getMailClient()
            );

            self::assertEquals(
                $commandeDTO->getMontant(), $commandeDTO_DBRESPONSE->getMontant()
            );

            self::assertEquals(
                $commandeDTO->getDelai(), $commandeDTO_DBRESPONSE->getDelai()
            );

            self::assertEquals(
                $commandeDTO->getEtat(), $commandeDTO_DBRESPONSE->getEtat()
            );
        }

    }

    public function testGetCommande(){
        foreach (self::$commandeIds as $id){

            $commandeEntity = Commande::find($id);
            $commandeDTO = self::$serviceCommande->accederCommande($id);

            $this->assertNotNull($commandeDTO);
            $this->assertNotNull($commandeEntity);

            $this->assertEquals($id, $commandeDTO->getId());
            $this->assertEquals($commandeEntity->mail_client, $commandeDTO->getMailClient());
            $this->assertEquals($commandeEntity->etat, $commandeDTO->getEtat()); // TODO: check if this is correct
            $this->assertEquals($commandeEntity->type_livraison, $commandeDTO->getTypeLivraison());
            $this->assertEquals($commandeEntity->montant_total, $commandeDTO->getMontant());
            $this->assertSameSize($commandeEntity->items, $commandeDTO->getItemsDTO());
        }

    }

    public function testValiderCommande(){
        foreach (self::$commandeIds as $id){
            $commandeDTO = self::$serviceCommande->validerCommande($id);
            $this->assertEquals(Commande::ETAT_VALIDE, $commandeDTO->getEtat());
        }
    }

}