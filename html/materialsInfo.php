<div class="result-container ">
<label class="text-warning label">Goods Code</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="goodscode" id="goodsCode" value="<?php echo $row['GOODS_CODE']?>">
</div>
               
<div class="result-container ">
<label class="text-warning label">Item Code</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="itemCode" id="itemCode" value="<?php echo $row['ITEM_CODE']?>">
</div>

<div class="result-container ">
<label class="text-warning pr-2">Part Name</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="partName" id="partName" value="<?php echo $row['MATERIALS']?>">
</div>

<div class="result-container ">
<label class="text-warning pr-2">Part Number</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="partNumber" id="partNumber" value="<?php echo $partNumber?>">
</div>

<div class="result-container ">
<label class="text-warning pr-2">Total Stock</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="qty" id="currentStock" value="<?php echo $row['TOTAL_STOCK']?>">
</div>

<div class="result-container ">
<label class="text-warning pr-2">Location</label>
<input type="text" readonly class="txtbox bg-secondary text-warning" name="location" id="currentStock" value="<?php echo $row['LOC']?>">
</div>