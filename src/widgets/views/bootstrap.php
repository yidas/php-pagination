<nav aria-label="Page navigation example">
  <ul class="pagination <?php if($this->alignCenter):?>justify-content-center<?php endif?>">
    <?php if($this->firstPageLabel!==null):?><li class="<?=$this->pageCssClass?> <?=$this->firstPageCssClass?> <?php if($page<=1):?>disabled<?php endif ?>"><a <?=$linkAttributes?> href="<?=$this->pagination->createUrl(1);?>"><?=$this->firstPageLabel?></a></li><?php endif ?>
    <li class="<?=$this->pageCssClass?> <?=$this->prevPageCssClass?> <?php if($page<=1):?>disabled<?php endif ?>"><a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($page-1);?>"><?=$this->prevPageLabel?></a></li>
    <?php foreach ($this->_buttonStack as $key => $btnPage): ?>
    <li class="<?=$this->pageCssClass?> <?php if(($page)==$btnPage):?>active<?php endif ?>"><a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($btnPage);?>"><?=$btnPage?></a></li>
    <?php endforeach ?>
    <li class="<?=$this->pageCssClass?> <?=$this->nextPageCssClass?> <?php if($this->pagination->pageCount<=$page):?>disabled<?php endif ?>"><a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($page+1);?>"><?=$this->nextPageLabel?></a></li>
    <?php if($this->lastPageCssClass!==null):?><li class="<?=$this->pageCssClass?> <?=$this->lastPageCssClass?> <?php if($this->pagination->pageCount<=$page):?>disabled<?php endif ?>"><a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($this->pagination->pageCount);?>"><?=$this->lastPageLabel?></a></li><?php endif ?>
  </ul>
</nav>