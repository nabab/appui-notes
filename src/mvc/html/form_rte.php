<div v-bbn-fill-height>
  <bbn-form :source="source"
            ref="form"
            confirm-leave="<?=_("Êtes-vous sûr de vouloir quitter ce formulaire sans enregistrer vos modifications?")?>"
            action="/bbn/appui/notes/insert"
            :buttons="['submit']"
  >
    <bbn-rte v-model="source.content"
             class="bbn-100"
    ></bbn-rte>
  </bbn-form>
</div>