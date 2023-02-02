<h2>Warehouse management page</h2>
<?php if (isset($params['message'])): ?>
<div class='alert alert-warning'>
<strong><?php echo $params['message']; ?></strong>
</div>
<?php endif ?>
<?php
$session = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;

if(!$session){
    session_start();
};

$session_started = isset($_SESSION['username']);
//display list in a table.
$list = $params['list'] ?? null;
if (isset($list)) {
    if($session_started){
        echo <<<EOT
        <table class="table table-sm table-bordered table-striped table-hover caption-top table-responsive-sm">
        <caption>List of warehouse</caption>
        <thead class='table-dark'>
        <tr>
            <th>Code</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
EOT;
    }
   
    // $params contains variables passed in from the controller.
    foreach ($list as $elem) {
        if($session_started){
            echo <<<EOT
            <style>
            input {
              display: none;
            }
          </style>
          <input name="id" id="id" value={$elem->getId()}>
          <input name="code" id="code" value={$elem->getCode()}>
          <input name="address" id="address" value={$elem->getAddress()}>
    
                <tr>
                    <td><a href="index.php?action=warehouse/edit&id={$elem->getId()}">{$elem->getCode()}</a></td>               
                    <td>{$elem->getAddress()}</a></td>
                    <td><button class="btn btn-secondary"><a href="index.php?action=warehouse/stock&id={$elem->getId()}">Stocks</button></td>
                </tr>  
                </form>             
    EOT;
        
        }
      
    }
    echo "</tbody>";
    echo "</table>";
    echo "<div class='alert alert-info' role='alert'>";
    echo count($list), " elements found.";
    echo "</div>";   
} else {
    echo "No data found";
}

?>
