<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crm_push}}`.
 */
class m240815_052208_create_crm_push_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $tableName = Yii::$app->db->tablePrefix . 'crm_push';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable('crm_push');
        }

        $this->createTable('{{%crm_push}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull(),
            'lead_id' => $this->integer()->null(),
            'lead_status' => $this->integer()->null(),
            'data_save_time' => $this->integer()->null(),
            'push_time' => $this->integer()->null(),
            'status' => $this->integer()->defaultValue(0),
            'is_deleted' => $this->integer()->defaultValue(0)
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crm_push}}');
    }
}