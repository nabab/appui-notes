<div class="bbn-postit" :style="getStyle">
  <div style="width:100%">
    <div class="bbn-block-left">
      <i v-if="editing"
         @click="edit"
         title="<?=_('Update Note')?>"
         class="fas fa-save bbn-p"
      ></i>
      <i v-if="editing"
         @click="removeNote"
         title="<?=_('Remove Note')?>"
         class="fas fa-trash-alt bbn-p"
      ></i>
      <i v-if="editing"
         @click="showColorPicker = !showColorPicker"
         title="<?=_('Choose Color')?>"
         class="fas fa-paint-brush bbn-p"
      ></i>
      <bbn-colorpicker v-if="showColorPicker"
                       :preview="true"
                       @change="isModified = true; showColorPicker = false"
                       :cfg="{
                        palette: palette,
                        columns: 5,
                        tileSize: 32
                       }"
                       v-model="actualColor"
                       ref="colorpicker"
      ></bbn-colorpicker>
    </div>
    <div class="bbn-block-right bbn-c"
         v-html="fdate(creation)"
    ></div>
  </div>
  <div v-if="title"
       title="<?=_('Edit Title')?>"
       class="bbn-c bbn-p bbn-b bbn-w-100"
       v-text="html2text(title)"
       @click="editMode"
       :contenteditable="editing"
       @blur="changeText('title', $event)"
  ></div>
  <div title="<?=_('Edit Content')?>"
       class="bbn-p bbn-w-100"
       v-text="html2text(content)"
       @click="editMode"
       :contenteditable="editing"
       @blur="changeText('content', $event)"
   ></div>
</div>
