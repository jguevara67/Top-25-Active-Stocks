<!DOCTYPE html>
<html>
    <body>
        <?php

            require 'vendor/autoload.php';
            use MongoDB\Client;

            $m = new Client("mongodb://localhost:27017");

            $db = $m->selectDatabase('jg_db');

            $collection = $db->selectCollection('col_name');

            $sortField = 'sort';

            if(isset($_GET['sort']))
            {
                $sortField = $_GET['sort'];
            }

            $documents = $collection->find([], ['sort'=>[$sortField => 1]]);

            echo "<table border=\"1\">\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo "<th><a href='?sort=Index'>Index</a></th>";
            echo "<th><a href='?sort=Name'>Name</a></th>";
            echo "<th><a href='?sort=Symbol'>Symbol</a></th>";
            echo "<th><a href='?sort=Price_Intraday'>Price (Intraday)</a></th>";
            echo "<th><a href='?sort=Change'>Change</a></th>";
            echo "<th><a href='?sort=Volume'>Volume</a></th>";
            echo "</tr>\n";
            echo "</thead>\n";

            echo "<tbody>\n";

            echo "<tr>\n ";

            foreach($documents as $doc)
            {
                foreach($doc as $key => $value)
                {
                    if($key != '_id')
                    {
                        if($key == 'Volume')
                        {
                            echo "<td>";
                            $converted_val = (string) $value;
                            $converted_val .= "M";
                            echo "{$converted_val}";
                            echo "</td>";
                        }
                        else if($key == 'Change' && $value > 0)
                        {
                            echo "<td>";
                            $converted_val = (string) $value;
                            $converted_val = "+"."$value";
                            echo "{$converted_val}";
                            echo "</td>";
                        }
                        else
                        {
                            echo "<td>";
                            echo "{$value}";
                            echo "</td>";
                        }
                    }
                }
                echo "\n</tr>\n";
            }
            echo "</tbody>\n";
            echo "</table>\n";
        ?>
    </body>
</html>
    

