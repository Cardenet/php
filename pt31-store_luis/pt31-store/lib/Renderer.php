<?php
namespace proven\lib\views;

require_once 'model/User.php';
use proven\store\model\User;

require_once 'model/Category.php';
use proven\store\model\Category;

require_once 'model/Product.php';
use proven\store\model\Product;

require_once 'model/Warehouse.php';
use proven\store\model\Warehouse;


class Renderer {

    /**
     * renders a string with table html code to display an array of users
     * @param array $headers the array of column titles
     * @param array $data the array of users
     * @return string an html table string conversion 
     */
    public static function renderArrayOfUsersToTable(array $headers, array $data): string {
        $result = "<table border='1'><thead><tr>";
        //print headers
        for ($i=0; $i<count($headers); $i++) {
            $result .= sprintf("<th>%s</th>", $headers[$i]);
        }
        $result .= "</tr></thead><tbody>";
        //print data
        foreach ($data as $elem) {
            $result .= "<tr>";
            $result .= sprintf(
                    "<td>%d</td><td>%s</td><td>%s</td><td>%s</td>", 
                    $elem->getId(), $elem->getUsername(), 
                    $elem->getPassword(), $elem->getRole()
                );
            $result .= "</tr>"; 
        }
        $result .= "</tbody></table>";
        return $result;
    }
    
    /**
     * renders fields for a user's form
     * @param User $user 
     * @return string html representation of fields
     */
    public static function renderUserFields(User $user): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $user->getId(), "readonly placeholder='id'");
        $result .= self::renderLabelInput("Username: ", "username", $user->getUsername(), "placeholder='username'");
        $result .= self::renderLabelInput("Password: ", "password", $user->getPassword(), "placeholder='password'");
        $result .= self::renderLabelInput("Fistname: ", "firstname", $user->getFirstname(), "placeholder='firstname'");
        $result .= self::renderLabelInput("Lastname: ", "lastname", $user->getLastname(), "placeholder='lastname'");
        $result .= self::renderLabelInput("Role: ", "role", $user->getRole(), "placeholder='role'");
        $result .= "</fieldset>";
        return $result;
    }
    
    /**
     * renders html representation of a label-input pair
     * @param string $prompt text for the label
     * @param string $name the name of the input field
     * @param mixed $value the value for the input field
     * @param string $options other attributes for input field
     * @return string html representation
     */
    private static function renderLabelInput(string $prompt, string $name, mixed $value, string $options=""): string {
        $html = <<<EOT
        <div class="form-floating"> 
        <input name="$name" id="$name" class="form-control" value="$value" $options/>
        <label for="$name">$prompt</label>     
        </div>
        EOT;
        return $html;
    }




    // categories
        /**
     * renders fields for a category's form
     * @param Category $user 
     * @return string html representation of fields
     */
    public static function renderCategoryFields(Category $category): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $category->getId(), "readonly placeholder='id'");
        $result .= self::renderLabelInput("Code: ", "code", $category->getCode(), "placeholder='code'");
        $result .= self::renderLabelInput("Description: ", "description", $category->getDescription(), "placeholder='description'");
        $result .= "</fieldset>";
        return $result;
    }


    /**
     * renders fields for a product's form
     * @param Product $product 
     * @return string html representation of fields
     */
    public static function renderProductFields(Product $product): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $product->getId(), "readonly placeholder='id'");
        $result .= self::renderLabelInput("Code: ", "code", $product->getCode(), "placeholder='code'");
        $result .= self::renderLabelInput("Description: ", "description", $product->getDescription(), "placeholder='description'");
        $result .= self::renderLabelInput("Price: ", "price", $product->getPrice(), "placeholder='description'");
        $result .= self::renderLabelInput("Category: ", "category_id", $product->getCategoryId(), "placeholder='description'");
        $result .= "</fieldset>";
        return $result;
    }
    /**
     * renders fields for a warehouse's form
     * @param Warehouse $warehouse
     * @return string html representation of fields
     */
    public static function renderWarehouseFields(Warehouse $warehouse): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $warehouse->getId(), "readonly placeholder='id'");
        $result .= self::renderLabelInput("Code: ", "code", $warehouse->getCode(), "placeholder='code'");
        $result .= self::renderLabelInput("Address: ", "address", $warehouse->getAddress(), "placeholder='address'");
        $result .= "</fieldset>";
        return $result;
    }
}