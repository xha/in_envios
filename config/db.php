<?php

return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=web_innova',
    'dsn' => 'sqlsrv:server=localhost\SQL2014;Database=AEDONNINO', // MS SQL Server, dblib driver
    'username' => 'sa',
    'password' => 'sql2008SA',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
