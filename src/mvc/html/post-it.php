<div class="appui-note-postit bbn-overlay bbn-flex-height">
  <div class="bbn-c bbn-vmargin">
    <bbn-input placeholder="<?=_("Search")?>"
               autocomplete="off"
               style="width: 75%"
               class="bbn-xl"
               v-model="rechercher"
    ></bbn-input>
  </div>
  <div class="bbn-flex-fill">
    <bbn-scroll>
      <div class="bbn-postit-container">
        <appui-note-postit v-for="(note, index) in notes"
                            v-bind="note"
                            :key="index"                                                        
        ></appui-note-postit>
      </div>
    </bbn-scroll>
  </div>
</div>
