<?php
use Cygnite\AssetManager\Asset;
use Cygnite\Common\UrlManager\Url;
use Apps\Components\Wallscript\Time\TimeStamp;
use Apps\Models\FacebookPostsComments as FBComment;


    foreach ($posts as $post) {
        $comments = FBComment::findBySql("SELECT * FROM facebook_posts_comments where post_id = " . $post->p_id . " order by c_id asc");
        ?>		
		
			<script type="text/javascript">
		$(document).ready(function(){
				$("#stexpand<?php echo $post->p_id ;?>").oembed('<?php echo  htmlentities($post->post); ?>',{maxWidth: 400, maxHeight: 300});
		});
		</script>
		
        <div class="friends_area" id="record-<?php echo $post->p_id; ?>">
            <img src="<?php echo Url::getBase(); ?>assets/img/sanjoy_profile_post.jpg" style="float:left;" alt="" />
             <?php
            $userip = $_SERVER['REMOTE_ADDR'];
            if ($post->userip == $userip) {
                ?>
                <div class="delete trash-button" id="delete-id-<?php echo $post->p_id; ?>" style="float:right;" onclick="deletePost(<?php echo $post->p_id; ?>);"> X</div>
    <?php } ?>
	
            <span style="float:left" class="name">
                <b><?php echo $post->f_name; ?></b>
                <em><?php echo $link->convert(htmlentities($post->post)); ?></em>

                <div class="clear"> </div>
                <span id="time-stamp-<?php echo $post->p_id; ?>" class="timestamp" rel="<?php echo $post->date_created; ?>">
                <?php TimeStamp::convert($post->date_created); ?>
                </span>
            </span>
			
			<div id="stexpandbox" align="center" class="">
				<div id="stexpand<?php echo $post->p_id;?>" class="expandClass"></div>
				</div>
			
            <div class="name msg-comment-bottom"><a href="javascript: void(0)" id="post_id<?php echo $post->p_id; ?>" class="showCommentBox" onclick="displayCommentBox(<?php echo $post->p_id; ?>);" >Comments</a> </div>


            <div class="clear"> </div>

            <div id="CommentPosted<?php echo $post->p_id; ?>">
                <?php
                $comment_num_row = count(@$comments[0]->c_id);

                foreach ($comments as $cKey => $rows) {
                    ?>
                    <div class="commentPanel" id="record-<?php echo $rows->c_id; ?>" align="left">
                        <img src="<?php echo Url::getBase(); ?>assets/img/small_comment.jpg" class="comment-img" alt="" />
                        <span class="postedComments" style="float:left;">
        <?php echo $rows->comments; ?>
                        </span>
                        <div id="CID-<?php echo $rows->c_id; ?>" class="comment-delete trash-button" onclick="deleteComment(<?php echo $rows->c_id; ?>)">X</div>
                        <div class="clear"> </div>
                        <span style="margin-left:43px; color:#666666; font-size:11px">
        <?php TimeStamp::convert($rows->date_created); ?>

                        </span>
                        <?php
                        $userip = $_SERVER['REMOTE_ADDR'];
                        if ($rows->userip == $userip) {
                            ?>
                            &nbsp;&nbsp;
                    <?php } ?>
                    </div>
    <?php } ?>
            </div>
            <div class="comment-wrapper" align="left" id="comment-wrapper-<?php echo $post->p_id; ?>" <?php echo (($comment_num_row) ? '' : 'style="display:none"') ?>>
                <img src="<?php echo Url::getBase(); ?>assets/img/small_comment.jpg" width="40" class="comment-img" style="float:left;" alt="" />
                <div id="record-<?php echo $post->p_id; ?>">
                    <textarea class="comment-panel-div" id="comment-panel-div-<?php echo $post->p_id; ?>" name="comment-panel-div" cols="60" placeholder="What's on your mind?"></textarea>
                </div>
                <p clear="all" > <a id="submit-comment" class="btn-primary button comment" style="float:right;display:none;" onclick="submitComment();"> Comment</a></p>

                <div style="clear:both;"> </div>
            </div>
        </div>

<?php } ?>
