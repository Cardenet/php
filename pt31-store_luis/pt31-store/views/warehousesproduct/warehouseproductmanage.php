<h2>Warehouse management page</h2>
<?php if (isset($params['message'])): ?>
<div class='alert alert-warning'>
<strong><?php echo $params['message']; ?></strong>
</div>
<?php endif ?>
<?php
$list = $params['list'] ?? null;
if (isset($list)) {
    // $params contains variables passed in from the controller.
    echo <<<EOT
    <table class="table table-sm table-bordered table-striped table-hover caption-top table-responsive-sm">
    <caption>List of warehouse</caption>
    <thead class='table-dark'>
    <tr>
        <th>Warehouse id</th>
        <th>Product id</th>
        <th>Stock</th>
    </tr>
    </thead>
    <tbody>
EOT;
    foreach ($list as $elem) {
        
        echo <<<EOT
        <style>
        input {
          display: none;
        }
      </style>
      <input name="warehouse_id" id="warehouse_id" value={$elem->getWarehouse_id()}>
      <input name="product_id" id="product_id" value={$elem->getProduct_id()}>
      <input name="stock" id="stock" value={$elem->getStock()}>

            <tr>
                <td>{$elem->getWarehouse_id()}</td>               
                <td>{$elem->getProduct_id()}</td>
                <td>{$elem->getStock()}</td>
                
            </tr>  
            </form>             
EOT;
    
    }
    echo "</tbody>";
    echo "</table>";
    echo "<div class='alert alert-info' role='alert'>";
    echo count($list), " elements found.";
    echo "</div>";   
} 
