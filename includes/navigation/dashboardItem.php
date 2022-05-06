<?php
$test ="test";
?>
  <li class="articles__article" style="--animation-order:1"><a class="articles__link" href="<?=$url?>" data-ajax="false">
      <div class="articles__content articles__content--lhs">
        <h2 class="articles__title"><?=$label?></h2>
        <div class="articles__footer">
            <p><img src="images/<?=$image?>" style="height:130px;width:130px;"></p>
          <p style="position:absolute;bottom:20px;right:20px;"></p>
        </div>
      </div>
      <div class="articles__content articles__content--rhs" aria-hidden="true" data-ajax="false">
        <h2 class="articles__title"><?=$label?></h2>
        <div class="articles__footer">
          <p><img src="" style="height:130px;width:130px;"></p>
          <p style="position:absolute;bottom:20px;right:20px;width:140px"><?=$description?></p>
        </div>
      </div></a></li>
