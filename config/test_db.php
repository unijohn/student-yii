<?php
$db = require __DIR__ . '/db.php';

// test database! Important not to run tests on production or development databases
$db['dsn'] = 'sqlite:@app/tests/_data/testobase.db';

return $db;
