<?php

/**
 * Basic model for messages table
 */
class Message
{
    /**
     * database connector
     * @var medoo
     */
    private $database;

    /**
     * Table to read
     * @var string
     */
    private $tablename = 'messages';

    /**
     * Bootstrap class
     * @param medoo $database database connector
     */
    public function __construct(medoo $database)
    {
        $this->database = $database;
    }

    /**
     * Find all messages after a specific timestamp
     * @param  integer $timestamp
     * @return array
     */
    public function getAfter($timestamp)
    {
        return $this->database->select($this->tablename, ['name', 'message', 'created_at'],
                    ['ORDER' => 'created_at ASC', 'created_at[>]' => $timestamp]);
    }

    /**
     * Create a new message
     * @param  string $name    name of the user (VARCHAR(255))
     * @param  string $message message (TEXT)
     * @return null
     */
    public function create($name, $message)
    {
        $this->database->insert($this->tablename, [
            'name' => $name,
            'message' => $message,
            'created_at' => time()
        ]);
    }
}
