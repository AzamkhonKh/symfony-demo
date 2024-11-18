<?php
namespace App\Tests\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MySQLConnectionTest extends KernelTestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        self::bootKernel();  // Boot the Symfony kernel before accessing the container.

        // Get the Doctrine connection from the service container.
        $this->connection = self::$kernel->getContainer()->get('doctrine')->getConnection();

        // Manually ensure the connection is established.
        try {
            $this->connection->connect(); // Explicitly connect to the database
        } catch (Exception $e) {
            $this->fail('Failed to connect to the MySQL database: ' . $e->getMessage());
        }
    }

    public function testMySQLConnection(): void
    {
        $this->assertTrue($this->connection->isConnected(), 'Database is not connected.');

        try {
            // Perform a simple query to ensure the connection works
            $this->connection->executeQuery('SELECT 1');
            $this->assertTrue(true, 'MySQL connection is functional.');
        } catch (Exception $e) {
            $this->fail('Failed to connect to the MySQL database: ' . $e->getMessage());
        }
    }

    public function testSchemaExists(): void
    {
        // Check if a specific table exists (replace `product` with your table name)
        $schemaManager = $this->connection->createSchemaManager();

        $this->assertTrue(
            $schemaManager->tablesExist(['product']),
            'The required `product` table is missing from the database schema.'
        );
    }
}
