<div class="pagination">
  <?php if($this->firstPageLabel):?>
    <?php if($isFirst):?>
  <span <?=$linkAttributes?>><?=$this->firstPageLabel?></span>
    <?php else: ?>
  <a <?=$linkAttributes?> href="<?=$this->pagination->createUrl(1);?>"><?=$this->firstPageLabel?></a>
    <?php endif ?>
  <?php endif ?>

  <?php if($isFirst):?>
  <span <?=$linkAttributes?>><?=$this->prevPageLabel?></span>
  <?php else: ?>
  <a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($page-1);?>"><?=$this->prevPageLabel?></a>
  <?php endif ?>

  <?php foreach ($this->_buttonStack as $key => $btnPage): ?>
  <a <?=$linkAttributes?> class="<?php if(($page)==$btnPage):?>active<?php endif ?>" href="<?=$this->pagination->createUrl($btnPage);?>"><?=$btnPage?></a>
  <?php endforeach ?>
  
  <?php if($isLast):?>
  <span <?=$linkAttributes?>><?=$this->nextPageLabel?></span>
  <?php else: ?>
  <a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($page+1);?>"><?=$this->nextPageLabel?></a>
  <?php endif ?>

  <?php if($this->lastPageLabel):?>
    <?php if($isLast):?>
  <span <?=$linkAttributes?>><?=$this->lastPageLabel?></span>
    <?php else: ?>
  <a <?=$linkAttributes?> href="<?=$this->pagination->createUrl($this->pagination->pageCount);?>"><?=$this->lastPageLabel?></a>
    <?php endif ?>
  <?php endif ?>
</div>