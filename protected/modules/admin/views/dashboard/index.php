<div class="container-fluid">
    <?php
    $this->renderPartial("/layouts/_message");
    $Users = new Users();
    $Posts = new Posts();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><i class="ico-file mr5"></i>Postings</h5>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Posts->countPostByField(); ?></span></li>
                            <li class="list-group-item">Draft <span class="semibold pull-right"><?php echo $Posts->countPostByField("status", Posts::DRAFT); ?></span></li>
                            <li class="list-group-item">New <span class="semibold pull-right"><?php echo $Posts->countPostByField("status", Posts::PENDING_FOR_APPROVAL); ?></span></li>
                            <li class="list-group-item">Disabled <span class="semibold pull-right"><?php echo $Posts->countPostByField("status", Posts::DISABLED); ?></span></li>
                            <li class="list-group-item">Published <span class="semibold pull-right"><?php echo $Posts->countPostByField("status", Posts::PUBLISHED); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><i class="ico-user7 mr5"></i>Authors</h5>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Users->countAuthorByField(); ?></span></li>
                            <li class="list-group-item">Verified <span class="semibold pull-right"><?php echo $Users->countAuthorByField("is_verified", 1); ?></span></li>
                            <li class="list-group-item">Not Verified <span class="semibold pull-right"><?php echo $Users->countAuthorByField("is_verified", 0); ?></span></li>
                            <li class="list-group-item">Active <span class="semibold pull-right"><?php echo $Users->countAuthorByField("status", Users::ACTIVE); ?></span></li>
                            <li class="list-group-item">Inactive <span class="semibold pull-right"><?php echo $Users->countAuthorByField("status", Users::IN_ACTIVE); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h5 class="panel-title"><i class="ico-users mr5"></i>Users</h5>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">Total <span class="semibold pull-right"><?php echo $Users->countUserByField(); ?></span></li>
                            <li class="list-group-item">Verified <span class="semibold pull-right"><?php echo $Users->countUserByField("is_verified", 1); ?></span></li>
                            <li class="list-group-item">Not Verified <span class="semibold pull-right"><?php echo $Users->countUserByField("is_verified", 0); ?></span></li>
                            <li class="list-group-item">Active <span class="semibold pull-right"><?php echo $Users->countUserByField("status", Users::ACTIVE); ?></span></li>
                            <li class="list-group-item">Inactive <span class="semibold pull-right"><?php echo $Users->countUserByField("status", Users::IN_ACTIVE); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>