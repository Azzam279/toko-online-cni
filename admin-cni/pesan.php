<div class="panel panel-default">
	<div class="panel-heading">Pesan Masuk</div>
	<div class="panel-body">
	<?php
	$sql = $db->prepare("SELECT * FROM contact ORDER BY tgl DESC");
	$sql->execute();
	include_once("function.php");
	?>
	   <ul class="chat">
	   		<?php
	   		while ($contact = $sql->fetch(PDO::FETCH_OBJ)) {
	   		?>
            <li class="left clearfix"><span class="chat-img pull-left">
                <img src="<?php echo "$host/images/avatar_2x.png"; ?>" alt="User Avatar" class="img-circle" style="width:60px;" />
            </span>
                <div class="chat-body clearfix">
                    <div class="header">
                        <strong class="primary-font"><?php echo ucfirst($contact->nama); ?></strong> <small class="pull-right text-muted">
                            <span class="glyphicon glyphicon-time"></span> <?php echo time_since($contact->tgl); ?></small>
                    </div>
                    <p>
                        <p>Subjek : <?php echo $contact->subjek; ?></p>
                        <?php echo $contact->pesan; ?>
                        <p>
                        <br>
                        	<i>Email : <a href="mailto:#"><?php echo $contact->email; ?></a></i>
                        </p>
                    </p>
                </div>
            </li>
            <?php
        	}
            ?>
        </ul>
	</div>
</div>