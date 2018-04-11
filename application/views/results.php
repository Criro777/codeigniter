<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.min.css">
    <link href="/assets/font-awesome-4.7.0/css/font-awesome.min.css"  type="text/css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link href="/assets/css/style.css"  type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <title>Search results</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading head">
                    <h2>Поиск задания :</h2>
                </div>
                <div style="text-align: center" class="panel-body">
                    <form method="post" action="/search" id ="todoSearch">
                        <input type="text" class="form-control" required placeholder="Найти задание" id = "search" name="search">
                        <button class="btn btn-primary" type="submit">Найти</button>
                    </form>
                </div>
                <div style="text-align:center; margin-bottom: 15px;" class="main">
                    <a href="/" class="btn btn-info">На главную</a>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <h2>Результаты поиска:</h2>
                </div>
                <div class="panel-body">
                    <ul id="todoList">
                        <?php if (! empty($items)) : ?>
                            <?php foreach ($items as $item): ?>
                                <li>
                                    <div class="todoItem">
                                        <h2 data-pk ="<?php echo $item['id']?>" class='todoEditable'><?php echo $item['task']; ?> </h2>
                                        <input type="file" class = "fileinput-filename loadFile" id="<?php echo $item['id']?>" name="picture">
                                    </div>
                                    <?php if(! empty ($item['img_name'])): ?>
                                        <div class='image'>
                                            <a target='_blank' href="<?php echo $item['img_name']?>">
                                                <img height='150' width='150' src ="<?php echo $item['img_name']?>"/>
                                            </a>
                                            <i class="fa fa-close"></i>
                                        </div>
                                    <?php endif;?>
                                    <div class="tags">
                                        <input type="text" class="form-control" name="tag">
                                        <button class="btn btn-primary addTag">Добавить тег</button>
                                    </div>

                                    <div id="<?php echo $item['id']?>" class="tagList">Теги:
                                        <?php if(! empty ($tags)): ?>
                                            <?php foreach ($tags as $tag): ?>
                                                <?php if($tag['task_id'] === $item['id']): ?>
                                                    <span class="tagName"><?php echo $tag['tag_name']?></span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <h3><b>Ничего не найдено...</b></h3>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="/assets/js/script.js"></script>
</body>
</html>