<!-- HTML Document -->

<bbn-table :source="source.data"
           class="appui-notes-masks-table"
           editable="popup"
           ref="table"
           :url="source.root + 'actions/mask/update'"
           :order="[{text:'ASC'}]"
           :groupable="true"
           :group-by="3"
           >
  <bbns-column :title="_('ID')"
              field="id_note"
              :width="100"
              :hidden="true"
              :editable="false"
              ></bbns-column>
  <bbns-column :title="_('Défaut')"
              field="default"
              cls="bbn-c"
              :width="50"
              :component="$options.components.def"
              :editable="false"
              ></bbns-column>
  <bbns-column :title="_('Version')"
              field="version"
              type="number"
              :width="50"
              :editable="false"
              ></bbns-column>
  <bbns-column :title="_('Type de lettre')"
              field="id_type"
              :editable="false"
              :component="$options.components.cat"
              ></bbns-column>
  <bbns-column :title="_('Name')"
               field="name"
  ></bbns-column>
  <bbns-column :title="_('Objet')"
              field="title"
              ></bbns-column>
  <bbns-column :title="_('Dern. modif.')"
              field="creation"
              :editable="false"
              type="date"
              :width="120"
              ></bbns-column>
  <bbns-column :title="_('Utilisateur')"
              field="id_user"
              :editable="false"
              :width="150"
              :render="renderUser"
              ></bbns-column>
  <bbns-column :title="_('Texte')"
              field="content"
              editor="bbn-rte"
              :hidden="true"
              ></bbns-column>
  <bbns-column width='160'
              :title="_('Actions')"
              :buttons="getButtons"></bbns-column>

</bbn-table>