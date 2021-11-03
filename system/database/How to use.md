<h1>How to use</h1>
<b>Basic usage</b>
<pre>
$database = new Database;
$database->prepare($sql, $param1, $param2, ...);
$result = $database->fetchRow();
</pre>
<b>Set fetch mode</b><br>
You can set fetch mode by calling the function just like with PDO.
<pre>
$database = new Database;
$database->prepare($sql, $param1, $param2, ...);
$database->setFetchMode(PDO::FETCH_CLASS,"UserClass");
$result = $database->fetchRow();
</pre>
<b>Multiple executions</b><br>
You can execute prepared statement with multiple data sets.
<pre>
$database = new Database;
$database->prepare($sql);
$database->execute($param1);
$database->execute($param2);
</pre>
<b>Transactions</b><br>
You can use transactions just like with PDO.
<pre>
$database = new Database;
try{
    $database->beginTransaction();
    $database->prepare($sql,$params);
    $database->execute();
    $database->commit();
}catch(DatabaseException $exception){
    $database->rollback();
}

</pre>