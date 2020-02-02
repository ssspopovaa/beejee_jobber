<?php include ROOT . '/views/layouts/header.php'; ?>

<div class="container">  
   <div class="alert alert-success" role="alert">
       <div>
           <span>Сортировка: </span> <br>
           <a href="site/sort/1" ><button <?php if($_SESSION['sort'] == 1){ 
                                                echo 'style="background: grey;"';} ?>
                                          >По имени вниз</button></a>
           <a href="site/sort/2" ><button <?php if($_SESSION['sort'] == 2){ 
                                                echo 'style="background: grey;"';} ?>
                                          >По имени вверх</button></a>
           <a href="site/sort/3" ><button <?php if($_SESSION['sort'] == 3){ 
                                                echo 'style="background: grey;"';} ?> 
                                          >По статусу вниз</button></a>
           <a href="site/sort/4" ><button <?php if($_SESSION['sort'] == 4){ 
                                                echo 'style="background: grey;"';} ?>
                                          >По статусу вверх</button></a>
           <a href="site/sort/5" ><button <?php if($_SESSION['sort'] == 5){ 
                                                echo 'style="background: grey;"';} ?>
                                          >По Email вниз</button></a>
           <a href="site/sort/6" ><button <?php if($_SESSION['sort'] == 6){ 
                                                echo 'style="background: grey;"';} ?>
                                          >По Email вверх</button></a>
       </div>                  
   </div>
    <div class="list-group">
      <?php foreach ($tasks as $task): ?>  
        <a href="<?php echo User::isGuest() ? '#' : 'edit/'. $task['id']; ?>" class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?php echo $task['user']; ?></h5>
                <h5 class="mb-1"><?php echo $task['text']; ?></h5>
                <small><?php echo $task['done'] ? 'Выполнено' : 'Не выполнено' ;?></small>
              </div>
              <p class="mb-1"><?php echo $task['email']; ?></p>
              <small><?php echo $task['checked'] ? 'Отредактировано администратором' : '' ;?></small>
          </a>
      <?php endforeach; ?>
        <!-- Pagination -->
       <?php echo $pagination->get(); ?>
    </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>