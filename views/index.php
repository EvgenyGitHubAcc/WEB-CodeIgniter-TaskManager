<html>
<head>
    <meta charset="utf-8">
    <title>Расписание</title>
</head>
<body>

<form action="/Tasks/addBtnPr" method="post">
    <input type="date" name="Date" value="2019-01-01">
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

<?php
    for($i = 0; $i < count($arrayStr); ++$i)
    {
        if($arrayStr[$i]['DeadLine'] - time() > 60 * 60 * 24)
        {
            echo "<tr>
                <td>" . date("d.m.Y", (int)$arrayStr[$i]['DeadLine']) . "</td>
                <td>" . $arrayStr[$i]['Task'] . "</td>
                <td>
                    <a href='/Tasks/delLnkPr?DelLnk=" . $arrayStr[$i]['Id'] . "' >X</a>
                </td>
                 <td>
                    <a href='/Tasks/modLnkPr?ModLnk=" . $arrayStr[$i]['Id'] . "' >M</a>
                </td>
             </tr>";
        }
        else if($arrayStr[$i]['DeadLine'] - time() < 60 * 60 * 24 && $arrayStr[$i]['DeadLine'] - time() > 0)
        {
            echo "<tr>
                <td bgcolor='orange'>" . date("d.m.Y", (int)$arrayStr[$i]['DeadLine']) . "</td>
                <td bgcolor='orange'>" . $arrayStr[$i]['Task'] . "</td>
                <td bgcolor='orange'>
                    <a href='/Tasks/delLnkPr?DelLnk=" . $arrayStr[$i]['Id'] . "' >X</a>
                </td>
                 <td bgcolor='red'>
                    <a href='/Tasks/modLnkPr?ModLnk=" . $arrayStr[$i]['Id'] . "' >M</a>
                </td>
             </tr>";
        }
        else
        {
            echo "<tr>
                <td bgcolor='red'>" . date("d.m.Y", (int)$arrayStr[$i]['DeadLine']) . "</td>
                <td bgcolor='red'>" . $arrayStr[$i]['Task'] . "</td>
                <td bgcolor='red'>
                    <a href='/Tasks/delLnkPr?DelLnk=" . $arrayStr[$i]['Id'] . "' >X</a>
                </td>
                 <td bgcolor='red'>
                    <a href='/Tasks/modLnkPr?ModLnk=" . $arrayStr[$i]['Id'] . "' >M</a>
                </td>
             </tr>";
        }
    }
?>
</table>
</body>
</html>