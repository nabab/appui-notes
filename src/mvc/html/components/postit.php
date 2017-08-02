<div class="bbn-widget bbn-postit" :style="{backgroundColor: actualColor}">
  <div id="creation" style="width:100%">
    <input type="hidden" name="id_note" v-model="uid">
    <div id="bbn-block-left" class="bbn-block-left">
      <i v-show="editing"
         @click="update_note"
         title="Update Note"
         class="fa fa-save cursor"
      ></i>
      <i v-show="editing"
         @click="showColorPicker = !showColorPicker"
         title="Choose Color"
         class="fa fa-paint-brush"
      ></i>
      <bbn-colorpicker v-if="showColorPicker"
                       :preview="true"
                       name="color"
                       @change="colorIsChanged = true; showColorPicker = false"
                       :cfg="{
                        palette: palette,
                        columns:5,
                        tileSize:32
                       }"
                       v-model="actualColor"
                       ref="colorpicker">

      </bbn-colorpicker>
    </div>
    <div class="bbn-block-right cursor"
         title="Edit Date"
         v-html="fdate(creation)"
    ></div>
  </div>
  <div v-if="title" title="Edit Title" class="appui-c cursor appui-b bbn-w-100" v-html="title" @click="editTitle"></div>
  <div title="Edit Content"
       class="cursor bbn-w-100"
       v-html="content"
       @click="editContent"
       :contenteditable="editing"
       ></div>
</div>