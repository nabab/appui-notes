<bbn-form :source="source"
          ref="form"
          confirm-leave="<?=_("Are you sure you want to leave this form without saving your changes?")?>"
          :action="root + '/actions/update'"
          :buttons="['submit']"
          @success="afterSubmit"
>
  <bbn-markdown v-model="source.content"
                :spellChecker="true"
                class="bbn-100"
  ></bbn-markdown>
</bbn-form>