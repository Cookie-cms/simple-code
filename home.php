<?php 
require_once "inc/home.php"
?>

<img src="inc/api.php?show=body&side=front&file_name=<?php echo $uuid  ?>" />  
<img src="inc/api.php?show=body&side=back&file_name=<?php echo $uuid  ?>" />  
<h3><?php echo $playername  ?></h3>
<form action="inc/update.php" method="post"  enctype="multipart/form-data">
<input type="text" class="form-control" placeholder="Username" value="" name="new_username" id="username">
<input type="password" class="form-control" placeholder="Password" value="" name="new_password" id="password">
<input type="file" id="new_skin" name="new_skin">
<input type="file" id="new_cape" name="new_cape">
<button type="submit">Update</button>


</form>
<form action="inc/removecape.php" method="post">
        <button type="submit">remove cape</button>
    </form>