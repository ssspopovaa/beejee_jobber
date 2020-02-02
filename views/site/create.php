<?php include ROOT . '/views/layouts/header.php'; ?>

    <div class="container">
        <h4>Создание задачи</h4>
        <div class="row">
            <div class="col-lg-5">
                <?php if (strlen($success) > 0): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($errors) && is_array($errors)): ?>
                    <div class="lert alert-danger login-form" role="alert">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
        
                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <p>Имя</p>
                        <input type="text" name="name" placeholder="Имя">
                        <p>Email</p>
                        <input type="email" name="email" placeholder="email" >
                        <p>Описание задачи</p>
                        <textarea name="description" rows="3"></textarea>
                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include ROOT . '/views/layouts/footer.php'; ?>
