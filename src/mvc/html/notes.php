<div class="bbn-flex-height">
  <div class="bbn-w-100 bbn-block bbn-c bbn-vmargin" style="height: 80px">
    <input type="text" class="k-input bbn-textbox" placeholder="<?=_("Search")?>" autocomplete="off" style="width: 75%; font-size: x-large">
  </div>
  <div class="bbn-content bbn-postit-container bbn-w-100 bbn-flex-fill">
    <appui-notes-postit v-for="note in source.notes"
                        :key="note.id_note"
                        :uid="note.id_note"
                        :content="note.content"
                        :creation="note.creation"
                        :title="note.title"
                        :editing="isEditing(note.id_note)"
                        >
    </appui-notes-postit>
  </div>
</div>