<?php

declare(strict_types=1);

namespace Doctrine\DBAL\Tests\Driver\PgSQL;

use Doctrine\DBAL\Driver as DriverInterface;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\PgSQL\Driver;
use Doctrine\DBAL\Tests\Driver\AbstractPostgreSQLDriverTestCase;
use Doctrine\DBAL\Tests\TestUtil;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;

class DriverTest extends AbstractPostgreSQLDriverTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (isset($GLOBALS['db_driver']) && $GLOBALS['db_driver'] === 'pgsql') {
            return;
        }

        self::markTestSkipped('Test enabled only when using pgsql specific phpunit.xml');
    }

    /**
     * Ensure we can handle URI notation for IPv6 addresses
     */
    #[RequiresPhpExtension('pgsql')]
    public function testConnectionIPv6(): void
    {
        $params = TestUtil::getConnectionParams();
        $params['host'] = '[::1]';

        $connection = $this->connect((array)$params);

        self::assertInstanceOf(Connection::class, $connection);
    }

    protected function createDriver(): DriverInterface
    {
        return new Driver();
    }
}
