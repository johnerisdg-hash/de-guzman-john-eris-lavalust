<?php

class Repair_products_columns
{
    private $_lava;

    public function __construct()
    {
        $this->_lava = lava_instance();
        $this->_lava->call->dbforge();
    }

    public function up()
    {
        if (!$this->_lava->dbforge->table_exists('products')) {
            return;
        }

        $columns = [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE,
                'default' => '',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0,
            ],
            'stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE,
                'default' => 0,
            ],
        ];

        foreach ($columns as $column => $definition) {
            if (!$this->_lava->dbforge->column_exists('products', $column)) {
                $this->_lava->dbforge->add_column('products', [$column => $definition]);
            }
        }
    }

    public function down()
    {
        // Existing product data must not be removed by a rollback.
    }
}