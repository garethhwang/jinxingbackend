<?php echo $header; ?>

<style>
  body{background: #eee;}
</style>
<?php foreach($documents as $document) { ?>
<div class="userinfoList">
  <a href="<?php echo $document['href']?>;" ><?php echo $document['title']; ?><img src="image/catalog/newstyle/userinfoimg3.png" /></a>
</div>
<?php } ?>
</body>
</html>