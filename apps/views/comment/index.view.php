<?php
use Cygnite\AssetManager\Asset;
use Cygnite\Common\UrlManager\Url;
use Apps\Components\Wallscript\Time\TimeStamp;
use Apps\Models\FacebookPostsComments as FBComment;

echo Asset::script('assets/js/cygnite/jquery.js');
echo Asset::style('assets/css/fb_screen.css');
?>
<script type="text/javascript">
    var baseUrl = "<?php echo Url::getBase(); ?>";
</script>

<h3>Facebook Style Wall Posting Script using jQuery PHP and Ajax.</h3>

<br> <br>

<div align="">

            <div class="col-lg-8 col-md-4 col-sm-5" style="background:none repeat scroll 0 0 #EDEDED;">
                <div style="float:left"> <i class="glyphicon glyphicon-edit blue-color"></i>&nbsp;&nbsp;<label>Update Status </label> </div>
                <textarea class="form-control post-box" rows="3" id="post-share-box" name="post-share-box"  cols="60" placeholder="What's on your mind ?" ></textarea>


                <div class="" id="comment-bottom-container" style="background:#EDEEEF;paddin:10px 5px;">
                    &nbsp;
                    <!--<div class="comment-bottom-wrap"> <div class="btn-primary button comment"></div></div>-->
                    <span>PHP, Cygnite, JQuery, AJAX Programming + Tutorials ( <a href="http://www.appsntech.com" target="_blank" style="color:#EC092B">www.appsntech.com</a> ) </span>
                    &nbsp;&nbsp;&nbsp;
                    <button id="shareButton" class="btn-primary button comment" style="margin-top: 7px; margin-left:1px;width:67px;float:right;"> Post</button>
                </div>

            </div>

    <div class="clear"> </div>

    <div id="posting" align="left">

            <?php echo $this->commentWidget; ?>
    </div>
</div>

<div class="clear"></div>

<p>
<div id="load-more-bottom">
<a id="more_<?php echo count($this->posts); ?>" class="more_records" href="javascript: void(0)">Older Posts</a>
</div>
</p>

<style >
    .form-control textarea{
        font-size:20px;
    }
</style>


<div class="clear"> </div>