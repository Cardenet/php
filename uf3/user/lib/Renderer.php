<?php
namespace lib\views;
require_once 'model/User.php';

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
     * @param \user\model\User $user 
     * @return string html representation of fields
     */
    public static function renderUserFields(\user\model\User $user): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $user->getId(), "readonly");
        $result .= self::renderLabelInput("Username: ", "username", $user->getUsername());
        $result .= self::renderLabelInput("Password: ", "password", $user->getPassword());
        $result .= self::renderLabelInput("Role: ", "role", $user->getRole());
        $result .= "</fieldset>";
        return $result;
    }
    public static function renderUserFieldsid(\user\model\User $user): string {
        $result = "<fieldset>";
        $result .= self::renderLabelInput("Id: ", "id", $user->getId());
        $result .= self::renderLabelInput("Username: ", "username", $user->getUsername());
        $result .= self::renderLabelInput("Password: ", "password", $user->getPassword());
        $result .= self::renderLabelInput("Role: ", "role", $user->getRole());
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
        return sprintf("<label for='$name'>$prompt</label><input name='$name' value='$value' $options/>");
    }
}