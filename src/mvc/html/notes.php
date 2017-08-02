<div class="bbn-h-100">
  <div class="bbn-w-100 bbn-block bbn-c bbn-vmargin" style="height: 80px">
    <input type="text" class="k-input k-textbox" placeholder="<?=_("Rechercher")?>" autocomplete="off" style="width: 75%; font-size: x-large">
  </div>
  <div class="bbn-full-height bbn-content bbn-dashboard bbn-postit-container" >
    <div class="bbn-h-100">

    <appui-notes-postit v-for="note in source.notes"
                        :key="note.id_note"
                        :uid="note.id_note"
                        :content="note.content"
                        :creation="note.creation"
                        :title="note.title"
                        :editing="isEditing(note.id_note)"

    ></appui-notes-postit>
  </div>
</div>