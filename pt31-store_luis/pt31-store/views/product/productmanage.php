<!-- <h2>Product management page</h2>
<p>Sorry! Page under construction</p> -->
<h2>Product management page</h2>
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
if($session_started){
    echo <<<EOT
    <form method="post">
    <div class="row g-3 align-items-center">
      <span class="col-auto">
        <label for="search" class="col-form-label">Category to search</label>
      </span>
      <span class="col-auto">
        <input type="text" id="search" name="search" class="form-control" aria-describedby="searchHelpInline">
      </span>
      <span class="col-auto">
        <button class="btn btn-primary" type="submit" name="action" value="product/categoryid">Search</button>
      </span>
      <span class="col-auto">
        <button class="btn btn-primary" type="submit" name="action" value="product/form">Add</button>
      </span>
    </div>
    </form>
EOT;
    
}else{
  echo <<<EOT
  <form method="post">
  <div class="row g-3 align-items-center">
    <span class="col-auto">
      <label for="search" class="col-form-label">Category to search</label>
    </span>
    <span class="col-auto">
      <input type="text" id="search" name="search" class="form-control" aria-describedby="searchHelpInline">
    </span>
    <span class="col-auto">
    <button class="btn btn-primary" type="submit" name="action" value="product/categoryid">Search</button>
  </span>
  </div>
  </form>
EOT;

}

$session = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;

if(!$session){
    session_start();
};

$session_started = isset($_SESSION['username']);
//display list in a table.
//            <th>Id</th>
$list = $params['list'] ?? null;
if (isset($list)) {
  if($session_started){
    echo <<<EOT
    <form id="user-form" method="post" action="index.php">
        <table class="table table-sm table-bordered table-striped table-hover caption-top table-responsive-sm">
        <caption>List of categories</caption>
        <thead class='table-dark'>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
EOT;
  }else{
    echo <<<EOT
    <form id="user-form" method="post" action="index.php">
        <table class="table table-sm table-bordered table-striped table-hover caption-top table-responsive-sm">
        <caption>List of categories</caption>
        <thead class='table-dark'>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
EOT;
  }
   
    // $params contains variables passed in from the controller.
    //                <td><a href="index.php?action=user/edit&id={$elem->getId()}">{$elem->getId()}</a></td>
    //<a href="index.php?action=category/edit&id={$elem->getId()}"></a>
    //<td><form method='post' action=\"index.php\"><button type='submit' name='action' value='category/remove'>Remove</button></form></td>
    foreach ($list as $elem) {
      if($session_started){
        echo <<<EOT
        <style>
        input {
          display: none;
        }
      </style>
      <input name="id" id="id" value={$elem->getId()}>
      <input name="description" id="description" value={$elem->getDescription()}>
      <input name="code" id="code" value={$elem->getCode()}>
      <input name="price" id="price" value={$elem->getPrice()}>
      <input name="category_id" id="category_id" value={$elem->getCategoryId()}>
            <tr>
                <td>{$elem->getCode()}</a></td>               
                <td>{$elem->getDescription()}</a></td>
                <td>{$elem->getPrice()}</a></td>
                <td><button class="btn btn-secondary"><a href="index.php?action=product/stock&id={$elem->getId()}">Stocks</a></button><button type='submit' class="btn btn-warning" name='action' value='product/modify'><a href="index.php?action=product/edit&id={$elem->getId()}">Modify</a></button><button type='submit' class="btn btn-danger" name='action' value='product/remove'><a href="index.php?action=product/edit&id={$elem->getId()}">Remove</a></button></td>
            </tr>  
            </form>             
EOT;
      }else{
        echo <<<EOT
        <style>
        input {
          display: none;
        }
      </style>
      <input name="id" id="id" value={$elem->getId()}>
      <input name="description" id="description" value={$elem->getDescription()}>
      <input name="code" id="code" value={$elem->getCode()}>
      <input name="price" id="price" value={$elem->getPrice()}>
      <input name="category_id" id="category_id" value={$elem->getCategoryId()}>
            <tr>
                <td>{$elem->getCode()}</a></td>               
                <td>{$elem->getDescription()}</a></td>
                <td>{$elem->getPrice()}</a></td>
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
