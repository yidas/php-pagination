<nav aria-label="Page navigation example">
  <ul class="pagination <?php if($this->alignCenter):?>justify-content-center<?php endif?> <?=$this->ulCssClass?>">
    <?php if($this->firstPageLabel):?>
    <li class="<?=$this->pageCssClass?> <?=$this->firstPageCssClass?> <?php if($isFirst):?>disabled<?php endif ?>">
      <?php if($isFirst):?>
      <span <?=$linkAttributes?> class="page-link"><?=$this->firstPageLabel?></span>
      <?php else: ?>
      <a <?=$linkAttributes?> class="page-link" href="<?=$this->pagination->createUrl(1);?>"><?=$this->firstPageLabel?></a>
      <?php endif ?>
    </li>
    <?php endif ?>
    <li class="<?=$this->pageCssClass?> <?=$this->prevPageCssClass?> <?php if($isFirst):?>disabled<?php endif ?>">
      <?php if($isFirst):?>
      <span <?=$linkAttributes?> class="page-link"><?=$this->prevPageLabel?></span>
      <?php else: ?>
      <a <?=$linkAttributes?> class="page-link" href="<?=$this->pagination->createUrl($page-1);?>"><?=$this->prevPageLabel?></a>
      <?php endif ?>
    </li>
    <?php foreach ($this->_buttonStack as $key => $btnPage): ?>
    <li class="<?=$this->pageCssClass?> <?php if(($page)==$btnPage):?>active<?php endif ?>">
      <a <?=$linkAttributes?> class="page-link" href="<?=$this->pagination->createUrl($btnPage);?>"><?=$btnPage?></a>
    </li>
    <?php endforeach ?>
    <li class="<?=$this->pageCssClass?> <?=$this->nextPageCssClass?> <?php if($isLast):?>disabled<?php endif ?>">
      <?php if($isLast):?>
      <span <?=$linkAttributes?> class="page-link"><?=$this->nextPageLabel?></span>
      <?php else: ?>
      <a <?=$linkAttributes?> class="page-link" href="<?=$this->pagination->createUrl($page+1);?>"><?=$this->nextPageLabel?></a>
      <?php endif ?>
    </li>
    <?php if($this->lastPageLabel):?>
    <li class="<?=$this->pageCssClass?> <?=$this->lastPageCssClass?> <?php if($isLast):?>disabled<?php endif ?>">
      <?php if($isLast):?>
      <span <?=$linkAttributes?> class="page-link"><?=$this->lastPageLabel?></span>
      <?php else: ?>
      <a <?=$linkAttributes?> class="page-link" href="<?=$this->pagination->createUrl($this->pagination->pageCount);?>"><?=$this->lastPageLabel?></a>
      <?php endif ?>
    </li>
    <?php endif ?>
  </ul>
</nav>