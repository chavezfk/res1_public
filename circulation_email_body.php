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

?>

<h2>Reservation on <?php echo $_POST['rezdate'] ?></h2>

    from <?php echo $_POST['arr_time'] ?> to <?php echo $_POST['dep_time']. "\n"  ?>
<?php if ($_POST['recur'] != "false"): ?>
    Recurs: <?php echo $repeatlabels[$_POST['repeats']] . "\n" ?>
    Days:   <?php echo join(", ", array_map('ucfirst', array_keys($_POST['days']))) . "\n"; ?>
    Until:  <?php echo $_POST['until'] . "\n" ?>
<?php endif; ?>

<h3>Contact Info:</h3>

<dl>
    <dt>Group</dt>
    <dd><?php echo $_POST['group_name'] ?></dd>

    <dt>Name</dt>
    <dd><?php echo $_POST['name'] ?> &lt;<?php echo $_POST['email'] ?>&gt;</dd>

    <dt>Phone</dt>
    <dd><?php echo $_POST['phone'] ?></dd>
</dl>

    <h3>Affiliation:</h3>

<dl>
    <?php
    if ($_POST['tech'])
        echo "NMT\n";
    elseif ($_POST['federal'])
        echo "Federal Government\n";
    elseif ($_POST['state'])
        echo "NM State Government\n";
    ?>
</dl>


<h3>Venue:</h3>

<dl>

    <dt>Room:</dt>
    <dd><?php echo $_POST['room'] ?></dd>

    <dt>Needs:</dt>
    <dd> <ul>
            <?php

            foreach (array('needsdvd', 'needscomputer', 'needsprojector', 'needsphone') as $need)
                if ($_POST[$need])
                    echo "<li>". $needlabels[$need] ."</li>";
            ?>
        </ul>
    </dd>


</dl>


    <h3>Instructions:</h3>
        <dl><?php echo str_replace("\n", "\n        ", $_POST['instructions'])?> </dl>
