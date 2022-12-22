<?php

use Joomla\Database\DatabaseDriver;

class QlDatabaseTable
{
    /** @var DatabaseDriver */
    private $db;

    const TABLE_MESSAGES = '#__qlmessages';
    const TABLE_PRIORITY = '#__qlmessages_priority';

    private $sqlCreateMessages = "CREATE TABLE IF NOT EXISTS {table} (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` mediumtext NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `done` datetime NOT NULL,
  `done_at` datetime NOT NULL,
  `done_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `priority_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    private $sqlTruncateMessages = "TRUNCATE TABLE {table}";

    private $sqlDropMessages = "DROP TABLE {table}";

    private $sqlCreatePriority = "CREATE TABLE IF NOT EXISTS {table} (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `priority` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `ordering` datetime NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    private $sqlInsertPriority = "INSERT INTO {table} 
    (`priority`, `title`, `description`, `ordering`, `state`) VALUES
(1, 'Critical', 'issue that is critical to business on a productive system', 1, 1),
(1, 'High', 'issue that is critical to business on a productive system, yet user can use a work-around', 1, 1),
(1, 'Medium', 'issue that impacts the productive system, yet only a part of functionality is affected', 1, 1),
(1, 'Low', 'issue that is non-critical to businessm beauty, css whatever', 1, 1)";

    private $sqlTruncatePriority = "TRUNCATE TABLE {table}";

    private $sqlDropPriority = "DROP TABLE {table}";

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setUp()
    {
        $this->createAll();
    }

    public function createAll()
    {
        $this->createMessages();
        $this->createPriority();
    }

    public function createMessages()
    {
        $this->setQuery($this->sqlCreateMessages, ['table' => self::TABLE_MESSAGES]);
    }

    public function createPriority()
    {
        $this->setQuery($this->sqlCreatePriority, ['table' => self::TABLE_PRIORITY]);
    }

    public function truncateAll()
    {
        $this->truncateMessages();
        $this->truncatePriority();
    }

    public function truncateMessages()
    {
        $this->setQuery($this->sqlTruncateMessages, ['table' => self::TABLE_MESSAGES]);
    }

    public function truncatePriority()
    {
        $this->setQuery($this->sqlTruncatePriority, ['table' => self::TABLE_PRIORITY]);
    }

    public function dropAll()
    {
        $this->dropMessages();
        $this->dropPriorities();
    }

    public function dropMessages()
    {
        $this->setQuery($this->sqlDropMessages, ['table' => self::TABLE_MESSAGES]);
    }

    public function dropPriorities()
    {
        $this->setQuery($this->sqlDropPriority, ['table' => self::TABLE_PRIORITY]);
    }

    private function setQuery(string $sql, array $replaces = [])
    {
        $replaces = $this->getPlaceholder($replaces);
        $sql = str_replace(array_keys($replaces), $replaces, $sql);
        $this->db->setQuery($sql);
    }

    private function getPlaceholder(array $replaces):array
    {
        $return = [];
        foreach ($replaces as $placeholder => $replacement) {
            $return['{' .$placeholder  . '}'] = $replacement;
        }
        return $return;
    }

}