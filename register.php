<?php

$needlabels = array(
    'needsphone' => 'Phone',
    'needscomputer' => 'Computer',
    'needsprojector' => 'Projector',
    'needsdvd' => 'DVD player');

$repeatlabels = array(
    "not"     => "Does Not Repeat",
    "daily"   => "Daily",
    "weekday" => "Every Week Day",
    "mwf"     => "Every Monday, Wednesday and Friday",
    "tt"      => "Every Tuesday and Thursday",
    "weekly"  => "Weekly",
    "monthly" => "Monthly");


ob_start();
?>

Reservation Date: <?php echo $_POST['rezdate']. "\n" ?>
    from <?php echo $_POST['arr_time'] ?> to <?php echo $_POST['dep_time']. "\n"  ?>
<?php if ($_POST['recur'] != "false"): ?>
    Recurs: <?php echo $repeatlabels[$_POST['repeats']] . "\n" ?>
    Days:   <?php echo join(", ", array_map('ucfirst', array_keys($_POST['days']))) . "\n"; ?>
    Until:  <?php echo $_POST['until'] . "\n" ?>
<?php endif; ?>

Contact Info:

    Group:       <?php echo $_POST['group_name']. "\n"  ?>
    Name:        <?php echo $_POST['name'] ?> &lt;<?= $_POST['email'] ?>&gt;
    Phone:       <?php echo $_POST['phone']. "\n"  ?>
    Affiliation: <?php
if ($_POST['tech'])
    echo "NMT\n";
elseif ($_POST['federal'])
    echo "Federal Government\n";
elseif ($_POST['state'])
    echo "NM State Government\n";
?>

Venue:

    Room: <?php echo $_POST['room']. "\n"  ?>
    Needs:
<?php

foreach (array('needsdvd', 'needscomputer', 'needsprojector', 'needsphone') as $need)
  if ($_POST[$need])
    echo "      - ". $needlabels[$need]. "\n";
?>
    Instructions:
        <?php echo str_replace("\n", "\n        ", $_POST['instructions']). "\n"  ?>

<?php

var_dump($_POST);
foreach ($_POST as $key => $value)
    echo "$key: $value\n";

$body = ob_get_clean();
// mail('fusion@storytotell.org', 'Room Reservation', $body);
echo "<pre>". $body;

?>