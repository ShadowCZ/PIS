<html>
    <h3>Bank Account Statement</h3>
    <p>Account number: <strong><?php echo $account_number; ?></strong></p>
    <p>Account type: <strong><?php echo $account_type; ?></strong></p>
    <p>Account owner: <strong><?php echo $client; ?></strong></p>
    <p>Statement date: <strong><?php echo $from; ?></strong> - <strong><?php echo $to; ?></strong></p> 
    <hr>
    <br>
    <table style="border: 1px solid black; width: 100%;">
        <tr><th>ID</th><th>Date</th><th>Type</th><th>Account</th><th>VS</th><th>SS</th><th>CS</th><th>Message</th><th>Amount</th></tr>
    <?php
    $items = 0;
    $sum = 0;
    foreach ($operations as $operation) {
            $items++;
            echo "<tr>";
            echo "<td>".$operation->ID."</td>";
            $date = new DateTime($operation->date);
            echo "<td>".$date->format('Y-m-d')."</td>";
            echo "<td>".$operation->type->name."</td>";
            if ($operation->targetAccount != NULL) {
                echo "<td>".$operation->targetAccount. "/" . $operation->bank."</td>";
            }
            else {
                echo "<td>-</td>";
            }
            if ($operation->VS != NULL) {
                echo "<td>".$operation->VS."</td>";
            }
            else {
                echo "<td>-</td>";
            }
            if ($operation->SS != NULL) {
                echo "<td>".$operation->SS."</td>";
            }
            else {
                echo "<td>-</td>";
            }
            if ($operation->CS != NULL) {
                echo "<td>".$operation->CS."</td>";
            }
            else {
                echo "<td>-</td>";
            }
            echo "<td>".$operation->message."</td>";
            echo "<td>".$operation->value."</td>";
            echo "</tr>";
            $sum += $operation->value;
    }
    ?>
    </table>
    <p>Statement items: <strong><?php echo $items; ?></strong></p>
    <p>Items amount SUM: <strong><?php echo $sum; ?></strong></p>

</html>

