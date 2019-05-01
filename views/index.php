<html>
<head>
    <meta charset="utf-8">
    <title>Расписание</title>
</head>
<body>

<form action="/Tasks/addBtnPr" method="post">
    <input type="date" name="Date" value="<?=date("Y-m-d", time())?>">
    <input type="text" name="Task" placeholder="Введите задание">
    <input name="AddBtn" value="Добавить" type="submit">
</form>

<form action="/Users/logout" method="post">
    <input name="LogoutBtn" value="Выйти" type="submit">
</form>

<form action='/Users/delBtnPr' method='post'>
    <input name='DelProfBtn' value='Удалить профиль' type='submit'>
</form>

<table name="TaskTable" border="1">
    <tr>
        <th>Дата</th>
        <th>Задание</th>
        <th>Удаление</th>
        <th>Редактирование</th>
    </tr>

<?php foreach($arrayStr as $elem):
    {
        if($elem->DeadLine - time() > 60 * 60 * 24)
        {
            $color = 'white';
        }
        else if($elem->DeadLine - time() < 60 * 60 * 24 && $elem->DeadLine - time() > 0)
        {
            $color = 'orange';
        }
        else
        {
            $color = 'red';
        }
    }
?>
       <tr>
           <td bgcolor=<?=$color?> > <?= date("d.m.Y", (int)$elem->DeadLine) ?></td>
           <td bgcolor=<?=$color?> > <?= $elem->Task ?></td>
           <td bgcolor=<?=$color?> >
               <a href= <?='/Tasks/delLnkPr?DelLnk=' . $elem->Id . '' ?> >X</a>
           </td>
           <td bgcolor=<?=$color?> >
               <a href= <?='/Tasks/modLnkPr?ModLnk=' .  $elem->Id .  '' ?> >M</a>
           </td>
       </tr>
<?php endforeach; ?>
</table>
</body>
</html>