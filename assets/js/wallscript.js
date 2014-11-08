/**
 * @author : Sanjoy Dey
 * @url: www.appsntech.com
 * @category : facebook wallscript
 */

function displayCommentBox(id)
{
    $("#comment-wrapper-"+id).css('display','');
    $("#comment-wrapper-"+id).children("comment-img").show();
    $("#comment-wrapper-"+id).children("a#submit-comment").show();
}

function submitComment()
{
    var getpID =  $("a.comment").parent().parent().attr('id').replace('comment-wrapper-','');
    var comment_text = $("#comment-panel-div-"+getpID).val();
	
    if(comment_text != '' )
    {
        $.ajax({
            type: 'post',
            url: baseUrl+"index.php/comment/add_comment/",
            dataType: "json",
            data: {
                'comment' : comment_text,
                'post_id': getpID
            },
            success: function(response){
                $('#CommentPosted'+getpID).append($('<div id="record-'+ response.comment_id+'" class="commentPanel" align="left" style=" border-left: 3px solid #5890FF;"><img class="comment-img" alt="" src="'+baseUrl+'"/assets/img/small_comment.jpg"> <span class="postedComments">'+response.comment+' </span><div id="comment-delete-'+response.comment_id+'" class="comment-delete trash-button"  onclick="deleteComment('+response.comment_id+')">X</div><br clear="all"><span style="margin-left:43px; color:#666666; font-size:11px"> few seconds ago </span></div>').fadeIn('slow'));
                $("#comment-panel-div-"+getpID).val("").attr("placeholder", "Write a comment...");
            }
        });
        return false;
    } else {
        alert("This status update appears to be blank.");
        return false;
    }
}
function deleteComment(id)
{
    if(confirm('Are you sure you want to delete this comment?')==false)
        return false;
    $.ajax({
        type: 'post',
        url: baseUrl+"index.php/comment/delete-comment/",
        data: {
            'id' : id
        },
        beforeSend: function(){
        },
        success: function(){
            $("#record-"+id).fadeOut(300, function(){
                $(this).remove();
            });
        }
    });
}

function deletePost(id)
{

    if(confirm('Are you sure you want to delete this post?')==false)
        return false;
		
    $.ajax({
        type: 'post',
        url: baseUrl+"index.php/comment/delete/",
        data: {
            'id' : id
        },
        beforeSend: function(){
        },
        success: function(){
		
            $("#record-"+id).fadeOut(300, function(){
                $(this).remove();
            });
        }
    });
}
/*
function getSiteContent(url)
{

    $.ajax({
        type: 'post',
        url: baseUrl+"index.php/comment/web-scrap/",
        data: { 'url' : url  },
        beforeSend: function(){
        },
        success: function(response){
           $(".scrap-content").html(response);
        }
    });
}*/

$(function() {

    $("#submit-comment").hide();
    $('.comment-panel-div').on("focus", function(e) { 
        var parent  = $('.comment-panel-div').parent(), ID = $(this).attr('id').replace("comment-panel-div-", '');
        
        $(".comment-wrapper").children(".comment-panel-div");
        $("#comment-wrapper-"+ID+" p").children("a#submit-comment").show();
        $("#comment-wrapper-"+ID+" p").children(".comment-img").show();
    });

    //more records show
    $('a.more_records').on("click", function(e){

        var Id =  $(this).attr('id');
        $("a.more_records").hide();
		
        $("#load-more-bottom").html("<img src='"+baseUrl+"/assets/img/fb_loading.gif'/>");
        $.ajax({
            type: 'post',
            dataType: 'json',
            cache: false,
            url: baseUrl+"index.php/comment/show-more/",
            data: {'limit' : Id.replace('more_','')},
            success: function(response) {
                  $("a.more_records").show();
                if (response.posts.length != 0) {
                    var nextNumber = Number(Id.replace('more_','')) + Number(response.count);
                    $("a.more_records").attr('id', 'more_'+nextNumber);
                    $('#posting').append($(response.posts).fadeIn('slow'));
                    $("#load-more-bottom").html("");
                } else {
                    $('#load-more-bottom').remove();
                }

            }
        });
    });

    // hover show remove button
    $('.friends_area').on("mouseenter", function(e){
        $(this).children("a.delete").show();
    });
    $('.friends_area').on("mouseleave", function(e){
        $('a.delete').hide();
    });

    $('#shareButton').click(function(){
        var value = $("#post-share-box").val();

        if(value != "" )
        {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: baseUrl+"index.php/comment/post/",
                data: {
                    'value' : value
                },
                success: function(response){

                    var htmlString = '';

                    htmlString = '<div id="record-'+response.id+'" class="friends_area">\n\
                            <img alt="" style="float:left;" src="'+baseUrl+'/assets/img/sanjoy_profile_post.jpg">\n\
                            <label class="name" style="float:left">\n\n\
                                <b> '+response.name+'</b> \n\
                               <em>'+response.post+' </em><br clear="all"> \n\
                              <span>few seconds ago </span> \n\
                            <a onclick="displayCommentBox('+response.id+'); " class="showCommentBox" id="post_id'+response.id+'" href="javascript: void(0)">Comments</a>\n\
                            </label>';
                    htmlString += '<div style="float:right;" id="delete-id-'+response.id+'" class="delete trash-button" onclick="deletePost("'+response.id+'");"> X</div> <br clear="all"><div id="CommentPosted'+response.id+'"></div>';

                    htmlString +=  '<div align="left" style="display:none;" id="comment-wrapper-'+response.id+'" class="comment-wrapper">\n\
                                       <img width="40" alt="" style="float:left;" class="comment-img" src="'+baseUrl+'/assets/img/small_comment.jpg"> \n\
                                         <div id="record-'+response.id+'"><textarea placeholder="What\'s on your mind?" cols="60" name="comment-panel-div" id="comment-panel-div-'+response.id+'" class="comment-panel-div"></textarea>\n\
                                       </div><p clear="all"> </p> <a style="float:right;display:none;" class="btn-primary button comment" id="submit-comment" onclick="submit-comment();"> Comment</a>\n\
                                       <div style="clear:both;"> </div> \n\
                                      </div>\n\
                                      </div>';


                    $('#posting').prepend($(htmlString).fadeIn('slow'));
                    $("#post-share-box").val("").attr("placeholder", "Write a comment...");
                }
            });
            return false;
        } else {
            alert("Please share post");
            return false;
        }
    });

});