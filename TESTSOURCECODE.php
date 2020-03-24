foreach($data as $row)
        {
            print $HTML=<<<HTML
            <tr>
            <td>{$row["prd_name"]}</td>
            <td> {$row["prd_price"]}&#8364 </td>
HTML;
            
            $prd_qty_array[$i] = intval($prd_qty_array[$i] - intval($row["prd_quantity"]));
            
            $td_color = ( $prd_qty_array[$i] >= 0 )? '<span style="color:green">':'<span style="color:red;font-size:12px;border:1px solid red;border-radius:5px;">';
            
            print $HTML=<<<HTML
            <td>{$td_color} {$row["prd_quantity"]} </span></td>
            <td> {$row["date"]} </td>
            </tr>
HTML;