<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?> 
<?php
$GLOBALS['z']  = $this->options->CDNURL;
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';$idcard="本文作者";
        } else {
            $commentClass .= ' comment-by-user';$idcard="其他编辑";
        }
    }else{$idcard="";
}
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    if ($comments->url) {
        $author = '<a href="' . $comments->url . '" target="_blank" rel="external nofollow">' . $comments->author . '</a>';
    } else {
        $author = $comments->author;
    }
?>
<li data-no-instant id="li-<?php $comments->theId(); ?>" class="comment-body<?php
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div id="<?php $comments->theId(); ?>" class="comment-id">
        <?php
           $host = 'https://cdn.v2ex.com';
           $url = '/gravatar/';
            $size = '100';
            $rating = Helper::options()->commentsAvatarRating;
            $hash = md5(strtolower($comments->mail));
            $email = strtolower($comments->mail);
           $sjtx = Typecho_Widget::widget('Widget_Options')->motx;
$qq=str_replace('@qq.com','',$email);
if(strstr($email,"qq.com") && is_numeric($qq) && strlen($qq) < 11 && strlen($qq) > 4)
{
$avatar = '//q.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
 
}else{
 
 $avatar = $host . $url . $hash . '?s=' . $size . '&r=' . $rating . '&d='.$sjtx;
}
        ?>
    <a href="<?php $comments->url(); ?>" target="_blank" rel="external nofollow">   
        <img class="avatar"
     src="<?php echo $avatar ?>" alt="<?php echo $comments->author; ?>" width="<?php echo $size ?>" height="<?php echo $size ?>" /></a>
        <div class="comment-main">
  <div class="comment-author">
<?php echo $author; ?><?php  echo '<span class="idcard">'.$idcard.'</span>';?>
<div class="comment-meta">
  <time class="comment-time"><?php echo timesince($comments->created);?></time> <span class="comment-reply"><?php $comments->reply(); ?></span>
</div></div>
     
  <p>   <?php get_comment_at($comments->coid); ?>  <?php 


$cos = preg_replace('#</?[p|P][^>]*>#','',$comments->content);

echo $cos;
 ?></p>
          
        </div>
    </div>
 
    <?php if ($comments->children) { ?>
        <div class="comment-children">
            <?php $comments->threadedComments($options); ?>
        </div>
    <?php } ?>
    
</li>
<?php } ?>
<div id="comments">
    <?php $this->comments()->to($comments); ?>
  

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond"  data-no-instant>
        <div class="cancel-comment-reply"><span class="response"><?php _e('发表新评论'); ?></span>
 <?php if($this->user->hasLogin()): ?>
            <span><?php _e('已登入: '); ?><a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a> <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a></span>
              <?php endif ; ?>
<span class="cancel-reply"><?php $comments->cancelReply(); ?></span></div>
        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
            <?php if($this->user->hasLogin()): ?>
<?php else: ?>
                <?php if($this->remember('author',true) != "" && $this->remember('mail',true) != "") : ?> 
                
              <div class="hyhl">
                    <span onClick='showhidediv("author_info")'; style="cursor:pointer;color:#2479cc;"><?php $this->remember('author'); ?></span>，<?php _e('欢迎回来'); ?> 
                    <span id="cancel-comment-reply"><?php $comments->cancelReply(); ?></span>
                </div>
                <span id="author_info" style="display:none;"><?php else : ?>
                <span id="author_info">
                <?php endif ; ?>
          <input type="text" name="author" maxlength="12" id="author" class="form-control" placeholder="<?php _e('称呼 *'); ?>" value="<?php $this->remember('author'); ?>">
          <input type="email" name="mail" id="mail" class="form-control" placeholder="<?php _e('电子邮箱 *'); ?>" value="<?php $this->remember('mail'); ?>">
          <input type="url" name="url" id="url" class="form-control" placeholder="<?php _e('网址(http://)'); ?>" value="<?php $this->remember('url'); ?>"> </span>
          
                <?php endif; ?> 
            <textarea name="text" id="textarea" class="form-control" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('misubmit').click();return false};" placeholder="<?php _e('在这里输入你的评论(Ctrl/Cmd+Enter也可以提交)...'); ?>" required ><?php $this->remember('text',false); ?></textarea>
         <div class="huaji">
      
<div class="OwO" id="qaq" >
<span>     
  <button type="submit" class="submit" id="misubmit"><?php _e('提交评论'); ?></button>
 </span>
</div>
            <?php $security = $this->widget('Widget_Security'); ?>
            <input type="hidden" name="_" value="<?php echo $security->getToken($this->request->getReferer())?>">
        </form>
    </div>   

</div>
    <?php else: ?>
    <h4 class="comment-close">此处评论已关闭</h4>
    <?php endif; ?>   <?php if ($comments->have()): ?>
<div class="info-com">    <?php $this->commentsNum(_t('暂无评论'), _t('仅有 <span class="comment-num">1</span> 条评论'), _t('已有 <span class="comment-num">%d</span> 条评论')); ?></div>
    <?php $comments->listComments(); ?>
    <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
    <?php endif; ?> 
<!--<nocompress>-->
<script>
function showhidediv(id){  
var sbtitle=document.getElementById(id);  
if(sbtitle){  
   if(sbtitle.style.display=='block'){  
   sbtitle.style.display='none';  
   }else{  
   sbtitle.style.display='block';  
   }  
}  
}
    
(function () {
    window.TypechoComment = {
        dom : function (id) {
            return document.getElementById(id);
        },
        create : function (tag, attr) {
            var el = document.createElement(tag);
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
            return el;
        },
        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom('<?php echo $this->respondId(); ?>'),
                input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];
            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });
                form.appendChild(input);
            }
            input.setAttribute('value', coid);
            if (null == this.dom('comment-form-place-holder')) {
                var holder = this.create('div', {
                    'id' : 'comment-form-place-holder'
                });
                response.parentNode.insertBefore(holder, response);
            }
            comment.appendChild(response);
            this.dom('cancel-comment-reply-link').style.display = '';
            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }
            return false;
        },
        cancelReply : function () {
            var response = this.dom('<?php echo $this->respondId(); ?>'),
            holder = this.dom('comment-form-place-holder'),
            input = this.dom('comment-parent');
            if (null != input) {
                input.parentNode.removeChild(input);
            }
            if (null == holder) {
                return true;
            }
            this.dom('cancel-comment-reply-link').style.display = 'none';
            holder.parentNode.insertBefore(response, holder);
            return false;
        }
    };
})();
</script><!--</nocompress>-->
