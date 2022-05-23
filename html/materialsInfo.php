<div class="result-container ">
<label class="">Goods Code</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="goodscode" id="goodsCode" value="<?php echo $row['GOODS_CODE']?>">
</div>
               
<div class="result-container ">
<label class="">Item Code</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
</div>

<div class="result-container ">
<label class="">Part Name</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="partName" id="partName" value="<?php echo $row['MATERIALS']?>">
</div>

<div class="result-container ">
<label class="">Part Number</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="partNumber" id="partNumber" value="<?php echo $partNumber?>">
</div>

<div class="result-container ">
<label class="">Total Stock</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="qty" id="currentStock" value="<?php echo $row['TOTAL_STOCK']?>">
</div>

<div class="result-container ">
<label class="">Assembly Line</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="AssyLine" id="AssyLine" value="<?php echo $row['ASSY_LINE']?>">
</div>

<!-- <div class="result-container ">
<label class="">Location</label>
<input type="text" readonly class="txtbox bg-secondary text-white" name="location" id="currentStock" value="<?php echo $row['LOC']?>">
</div> -->