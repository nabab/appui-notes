<div v-bbn-fill-height>
  <bbn-form :source="source"
            ref="form"
            confirm-leave="<?=_("Êtes-vous sûr de vouloir quitter ce formulaire sans enregistrer vos modifications?")?>"
            action="/bbn/appui/notes/insert"
            :buttons="['submit']"
  >
    <bbn-markdown v-model="source.content"
                  :spellChecker="true"
                  class="bbn-100"
    ></bbn-markdown>
  </bbn-form>
</div>