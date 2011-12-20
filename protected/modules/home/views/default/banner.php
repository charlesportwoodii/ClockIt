<? Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/banner.css'); ?>

<h2>Clocked Times and Scheduled Times</h2>
<table border = 1>
<?

    // Retrieve the number of days in the current month, and the next month if neccessary
    list($firstYear,$firstMonth,$firstDay) = explode('-', $timestamp);
    $firstDay = substr($firstDay, 0, strpos($firstDay, ' '));
    list($currentYear,$currentMonth,$currentDay) = explode('-', date('Y-m-d', time()));

    // Displays the headers
    // If the first month and the current month are the same, then we just have to print out the headers
    if ($firstMonth == $currentMonth) 
    {  
        echo '<tr>';
        for ($i = $firstDay; $i < $currentDay; $i++)
        {
            echo '<th>' . date('l<br /> M j',mktime(0, 0, 0, $firstMonth, $i, $firstYear)) . '</th>';
        }
        echo '</tr>';                   
        echo '<tr>';
    }
    else 
    {
        // If the two months are different, then we have to print out all the days in the first month, and then all the days in the second month
        $daysInFirstMonth = cal_days_in_month(CAL_GREGORIAN, $firstMonth, $firstYear);
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        
        echo '<tr>';
        
        for ($i = $firstDay; $i <= $daysInFirstMonth; $i++) 
        {
            echo '<th>' . date('l<br /> M j',mktime(0, 0, 0, $firstMonth, $i, $firstYear)) . '</th>';
        }
        
        for ($i = 1; $i < $currentDay; $i++)
        {
            echo '<th>' . date('l<br /> M j',mktime(0, 0, 0, $currentMonth, $i, $currentYear)) . '</th>';
        }
        
        echo '</tr>';
        echo '<tr>';
    } 

    // Displays the content
    // If the current month and the first month are the same, then we just list the data accordingly
    if ($firstMonth == $currentMonth)
    {
        for ($i = $firstDay; $i < $currentDay; $i++)
        {
            echo '<td>';
            foreach($dataReader as $k=>$v)
            {
                // Retrieve the appropriate date timestamps
                list($date,$time) = explode(' ',$v['shift_start']);
                list($date2,$time2) = explode(' ', $v['shift_end']);
                list($year,$month,$day) = explode('-',$date);
                if ((int)$day == $i)
                {
                    echo  $time . '<br />' . $time2 . '<br /><br />';
                }
            }
        }
    }
    else
    {
        // If the two months are different, then we have to print out all the days in the first month, and then all the days in the second month
        $daysInFirstMonth = cal_days_in_month(CAL_GREGORIAN, $firstMonth, $firstYear);
        $daysInCurrentMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        for ($i = $firstDay; $i <= $daysInFirstMonth; $i++)
        {
            echo '<td>';
            foreach($dataReader as $k=>$v)
            {
                // Retrieve the appropriate date timestamps
                list($date,$time) = explode(' ',$v['shift_start']);
                list($date2,$time2) = explode(' ', $v['shift_end']);
                list($year,$month,$day) = explode('-',$date);
                if ((int)$day == $i)
                {
                    echo  $time . '<br />' . $time2 . '<br /><br />';
                }
            }
            echo '</td>';
        }
        
        for ($i = 1; $i < $currentDay; $i++)
        {
            echo '<td>';
            foreach($dataReader as $k=>$v)
            {
                // Retrieve the appropriate date timestamps
                list($date,$time) = explode(' ',$v['shift_start']);
                list($date2,$time2) = explode(' ', $v['shift_end']);
                list($year,$month,$day) = explode('-',$date);
                if ((int)$day == $i)
                {
                    echo  $time . '<br />' . $time2 . '<br /><br />';
                }
            }
            echo '</td>';

        }
    }
?>
    </tr>
</table>
