<div class="bbn-overlay appui-notes-forum">
	<div class="bbn-overlay bbn-flex-height">
		<div v-if="toolbar"
				 class="bbn-header bbn-w-100"
				 ref="toolbar"
				 style="min-height: 30px"
		>
		<!-- toolbar -->
			<div v-if="toolbarButtons.length" class="bbn-spadded">
				<bbn-button v-for="(button, i) in toolbarButtons"
										class="bbn-hsmargin"
										:key="i"
										v-bind="button"
										@click="_execCommand(button)"
				></bbn-button>
			</div>
			<div v-else-if="typeof(toolbar) === 'function'"
					 v-html="toolbar()"
			></div>
			<component v-else
								 :is="toolbar"
			></component>
		</div>
		<!-- Main -->
		<div class="bbn-w-100 bbn-flex-fill">
			<bbn-scroll v-if="!isLoading">
        <appui-notes-forum-topic inline-template
                                 v-for="(d, i) in currentData"
                                 :key="i"
                                 class="bbn-w-100"
                                 :source="d"
        >
          <div class="bbn-w-100">
            <div :class="['bbn-flex-width', 'appui-notes-forum-topic', {'bbn-box': !($vnode.key%2), 'bbn-alt': !!($vnode.key%2)}]">
              <div class="bbn-spadded"
                   style="height: 42px; width: 42px"
              >
                <div class="bbn-100 bbn-middle">
                  <bbn-initial :user-id="source.creator"
                               :title="forum.usersNames(source.creator, source.users)"
                  ></bbn-initial>
                  <span v-if="forum.hasEditUsers(source.users)"
                        class="bbn-badge bbn-bg-webblue bbn-white appui-notes-forum-initial-badge bbn-s"
                        v-text="forum.usersNames(source.creator, source.users, true)"
                  ></span>
                </div>
              </div>
              <div class="bbn-spadded bbn-vmiddle bbn-p appui-notes-forum-hfixed appui-notes-forum-replies-badge"
                   title="<?=_('Replies')?>"
                   @click="toggleReplies()"
              >
                <i class="nf nf-fa-comments bbn-xl bbn-hsmargin"></i>
                <span :class="['bbn-badge', 'bbn-white', {'bbn-bg-red': !source.num_replies, 'bbn-bg-green': source.num_replies}]"
                      v-text="source.num_replies || 0"
                ></span>
              </div>
              <div class="bbn-flex-fill bbn-spadded">
                <div v-if="source.title"
                     v-text="forum.shorten(source.title, 120)"
                     class="bbn-b"
                     :title="source.title"
                ></div>
                <div ref="contentContainer"
                     :style="{'height': contentContainerHeight, 'overflow': 'hidden'}"
                >
                  <div class="bbn-flex-width">
										<i v-if="cutContentContainer && possibleHiddenContent"
	                     class="nf nf-fa-angle_right bbn-p bbn-m"
	                     title="<?=_('Show full text')?>"
	                     @click="showContentContainer('auto')"
	                     style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"
	                   ></i>
										 <i v-else-if="!cutContentContainer && possibleHiddenContent"
                       class="nf nf-fa-angle_left bbn-p bbn-m"
                       title="<?=_('Hidden full text')?>"
                       @click="showContentContainer('no_auto')"
                       style="margin: 0.2rem 0.5rem 0 0; font-weight: bold"
                    ></i>
                    <div v-html="cutContentContainer ? cutContent : source.content"
                         :style="{
                          'height': contentContainerHeight,
                          'text-overflow': cutContentContainer ? 'ellipsis' : 'unset',
                          'white-space': cutContentContainer ? 'nowrap' : 'unset',
                          'width': cutContentContainer ? '100px' : 'unset',
                          'overflow': cutContentContainer ? 'hidden' : 'unset'
                         }"
                         class="bbn-flex-fill"
                    ></div>
                    <div v-if="source.links && source.links.length && !cutContentContainer">
                      <fieldset class="bbn-widget">
                        <legend><?=_("Links:")?></legend>
                        <div v-for="l in source.links"
                             style="margin-top: 10px"
                        >
                          <div class="bbn-flex-width"
                               style="margin-left: 0.5em"
                          >
                            <div style="height: 96px">
                              <img v-if="l.name && l.id && forum.imageDom"
                                   :src="forum.imageDom + l.id + '/' + l.name"
                              >
                              <i v-else class="nf nf-fa-link"></i>
                            </div>
                            <div class="appui-notes-forum-link-title bbn-flex-fill bbn-vmiddle">
                              <div>
                                <strong>
                                  <a :href="l.content.url"
                                     v-text="l.title || l.content.url"
                                     target="_blank"
                                  ></a>
                                </strong>
                                <br>
                                <a v-if="l.title"
                                   :href="l.content.url"
                                   v-text="l.content.url"
                                   target="_blank"
                                ></a>
                                <br v-if="l.title">
                                <span v-if="l.content.description"
                                      v-text="l.content.description"
                                ></span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    <div v-if="source.files && source.files.length && !cutContentContainer">
                      <fieldset class="bbn-widget">
                        <legend><?=_("Files:")?></legend>
                        <div v-for="f in source.files">
                    <span style="margin-left: 0.5em"
                          :title="f.title"
                    >
                      <a class="media bbn-p"
                         @click="forum.downloadMedia(f.id)"
                      >
                        <i class="nf nf-fa-download" style="margin-right: 5px"></i>
                        <span v-text="f.name"></span>
                      </a>
                    </span>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                </div>
              </div>
              <template v-if="forum.topicButtons && forum.topicButtons.length"
                        v-for="tbtn in forum.topicButtons"
              >
                <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                     style="margin-left: 0.5rem"
                     :title="tbtn.title || ''"
                >
                  <i :class="['bbn-xl', 'bbn-p', tbtn.icon]"
                     @click="tbtn.action ? tbtn.action(source, _self) : false"
                  ></i>
                </div>  
              </template>
              <div v-if="forum.pinnable"
                   class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 0.5rem"
                   :title="source.pinned ? '<?=\bbn\str::escape_squotes(_('unpin'))?>' : '<?=\bbn\str::escape_squotes(_('pin'))?>'"
                   >
                <i :class="'nf nf-mdi-' + (source.pinned ? 'pin_off' : 'pin') + ' bbn-xl bbn-p'"
                   @click="source.pinned = !source.pinned; forum.$emit('pin', source)"
                   ></i>
              </div>
              <div v-if="!source.locked"
                   class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 0.5rem"
                   title="<?=_('Delete')?>"
              >
                <i class="nf nf-fa-trash bbn-xl bbn-p"
                   @click="forum.remove ? forum.remove(source, _self) : false"
                ></i>
              </div>
              <div v-if="(source.creator === forum.currentUser) || !source.locked || forum.canLock"
                   class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 0.5rem"
                   title="<?=_('Edit')?>"
              >
                <i class="nf nf-fa-edit bbn-xl bbn-p"
                   @click="forum.edit ? forum.edit(source, _self) : false"
                ></i>
              </div>
              <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   style="margin-left: 0.5rem"
                   title="<?=_('Reply')?>"
              >
                <i class="nf nf-fa-reply bbn-xl bbn-p"
                   @click="forum.reply ? forum.reply(source, _self) : false"
                ></i>
              </div>

              <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                   :title="'<?=_('Created')?>: ' + forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + forum.fdate(source.last_edit)) : '')"
                   style="margin-left: 0.5rem; width"
              >
                <i :class="['nf nf-fa-calendar', {'bbn-orange': source.creation !== source.last_edit}]"></i>
                <div class="bbn-c bbn-s" style="width: 10em">
                  <div v-text="(source.creation !== source.last_edit) ? forum.sdate(source.last_edit) : forum.sdate(source.creation)"></div>
                </div>
              </div>
            </div>
            <!-- Replies -->
            <div v-if="showReplies"
                 class="bbn-w-100"
            >
              <div v-if="!source.replies"
                   class="bbn-middle bbn-padded"
              ><?=_('LOADING')?>...</div>
              <div v-else>
                <appui-notes-forum-post inline-template
                                        v-for="(r, k) in source.replies"
                                        :source="r"
                                        :key="k"
                >
                  <div :class="['bbn-flex-width', 'appui-notes-forum-replies', {'bbn-box': !($vnode.key%2), 'bbn-alt': !!($vnode.key%2)}]">
                    <div class="bbn-spadded"
                         style="height: 42px; width: 42px"
                    >
                      <div class="bbn-100 bbn-middle">
                        <bbn-initial :user-id="source.creator"
                                     :title="topic.forum.usersNames(source.creator, source.users)"
                        ></bbn-initial>
                        <span v-if="topic.forum.hasEditUsers(source.users)"
                              class="bbn-badge bbn-bg-webblue appui-notes-forum-initial-badge bbn-s"
                              v-text="topic.forum.usersNames(source.creator, source.users, true)"
                        ></span>
                      </div>
                    </div>
                    <div class="bbn-flex-fill bbn-spadded">
                      <div v-if="source.id_parent !== source.id_alias"
                           class="bbn-vmiddle"
                      >
                        <i class="nf nf-fa-reply bbn-large icon-flip"></i>
                        <bbn-initial :user-id="source.parent_creator"
                                     :height="20"
                                     class="bbn-hsmargin"
                        ></bbn-initial>
                        <i class="nf nf-fa-calendar"></i>
                        <span v-text="topic.forum.fdate(source.parent_creation)"
                              :style="{
                                textDecoration: !source.parent_active ? 'line-through' : 'none',
                                marginLeft: '0.3rem'
                              }"
                              class="bbn-s bbn-s"
                        ></span>
                        <span v-if="!source.parent_active"
                              class="bbn-hsmargin bbn-i bbn-s"
                        ><?=_('deleted')?></span>
                      </div>
                      <div v-html="source.content"></div>
                      <div v-if="source.links.length">
                        <fieldset class="bbn-widget">
                          <legend><?=_("Links:")?></legend>
                          <div v-for="l in source.links"
                               style="margin-top: 10px"
                          >
                            <div class="bbn-flex-width"
                                 style="margin-left: 0.5em"
                            >
                              <div style="height: 96px">
                                <img v-if="l.name && topic.forum.imageDom"
                                     :src="topic.forum.imageDom + l.id + '/' + l.name"
                                >
                                <i v-else class="nf nf-fa-link"></i>
                              </div>
                              <div class="appui-notes-forum-link-title bbn-flex-fill bbn-vmiddle">
                                <div>
                                  <strong>
                                    <a :href="l.content.url"
                                       v-text="l.title || l.content.url"
                                       target="_blank"
                                    ></a>
                                  </strong>
                                  <br>
                                  <a v-if="l.title"
                                     :href="l.content.url"
                                     v-text="l.content.url"
                                     target="_blank"
                                  ></a>
                                  <br v-if="l.title">
                                  <span v-if="l.content.description"
                                        v-text="l.content.description"
                                  ></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                      </div>
                      <div v-if="source.files.length">
                        <fieldset class="bbn-widget">
                          <legend><?=_("Files:")?></legend>
                          <div v-for="f in source.files">
                            <span style="margin-left: 0.5em"
                                  :title="f.title"
                            >
                              <a class="media bbn-p"
                                 @click="topic.forum.downloadMedia(f.id)"
                              >
                                <i class="nf nf-fa-download" style="margin-right: 5px"></i>
                                <span v-text="f.name"></span>
                              </a>
                            </span>
                          </div>
                        </fieldset>
                      </div>
                    </div>
                    <template v-if="topic.forum.replyButtons && topic.forum.replyButtons.length"
                              v-for="rbtn in topic.forum.replyButtons"
                    >
                      <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                          style="margin-left: 0.5rem"
                          :title="rbtn.title || ''"
                      >
                        <i :class="['bbn-xl', 'bbn-p', rbtn.icon]"
                           @click="rbtn.action ? rbtn.action(source, topic.source, _self) : false"
                        ></i>
                      </div>  
                    </template>
                    <div v-if="!source.locked && !source.num_replies"
                         class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         style="margin-left: 0.5rem"
                         title="<?=_('Delete')?>"
                    >
                      <i class="nf nf-fa-trash bbn-xl bbn-p"
                         @click="topic.forum.remove ? topic.forum.remove(source, _self) : false"
                      ></i>
                    </div>
                    <div v-if="(source.creator === topic.forum.currentUser) || !source.locked || topic.forum.canLock"
                         class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         style="margin-left: 0.5rem"
                         title="<?=_('Edit')?>"
                    >
                      <i class="nf nf-fa-edit bbn-xl bbn-p"
                         @click="topic.forum.edit ? topic.forum.edit(source, _self) : false"
                      ></i>
                    </div>
                    <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         style="margin-left: 0.5rem"
                         title="<?=_('Reply')?>"
                    >
                      <i class="nf nf-fa-reply bbn-xl bbn-p"
                         @click="topic.forum.reply ? topic.forum.reply(source, _self) : false"
                      ></i>
                    </div>
                    <div v-if="source.num_replies"
                         class="bbn-spadded bbn-hsmargin bbn-vmiddle appui-notes-forum-hfixed appui-notes-forum-replies-badge"
                         title="<?=_('Replies')?>"
                    >
                      <i class="nf nf-fa-comments bbn-xl bbn-hsmargin"></i>
                      <span class="bbn-badge bbn-bg-green bbn-white"
                            v-text="source.num_replies"
                      ></span>
                    </div>
                    <div class="bbn-spadded bbn-vmiddle appui-notes-forum-hfixed"
                         :title="'<?=_('Created')?>: ' + topic.forum.fdate(source.creation) + ((source.creation !== source.last_edit) ? ('\n<?=_('Edited')?>: ' + topic.forum.fdate(source.last_edit)) : '')"
                         style="margin-left: 0.5rem"
                    >
                      <i :class="['nf nf-fa-calendar', {'bbn-orange': source.creation !== source.last_edit}]"></i>
                      <div class="bbn-c bbn-s" style="margin-left: 0.3rem">
                        <div v-text="(source.creation !== source.last_edit) ? topic.forum.sdate(source.last_edit) : topic.forum.sdate(source.creation)"></div>
                        <!--<div v-text="(source.creation !== source.last_edit) ? topic.forum.hour(source.last_edit) : topic.forum.hour(source.creation)"></div>-->
                      </div>
                    </div>
                  </div>
                </appui-notes-forum-post>
              </div>
              <!-- Replies footer -->
              <appui-notes-forum-pager inline-template
                                       :source="source"
                                       :key="'appui-notes-forum-pager-' + $vnode.key"
                                       ref="pager"
              >
                <div class="appui-notes-forum-pager bbn-widget appui-notes-forum-replies"
                     v-if="pageable || isAjax"
                >
                  <div class="bbn-block"
                       v-if="pageable"
                  >
                    <bbn-button icon="nf nf-fa-angle_double_left"
                                :notext="true"
                                title="<?=_('Go to the first page')?>"
                                :disabled="isLoading || (currentPage == 1)"
                                @click="currentPage = 1"
                    ></bbn-button>
                    <bbn-button icon="nf nf-fa-angle_left"
                                :notext="true"
                                title="<?=_('Go to the previous page')?>"
                                :disabled="isLoading || (currentPage == 1)"
                                @click="currentPage--"
                    ></bbn-button>
                    <span><?=_('Page')?></span>
                    <bbn-numeric v-if="source.replies && source.replies.length"
                                 v-model="currentPage"
                                 :min="1"
                                 :max="numPages"
                                 style="margin-right: 0.5em; width: 6em"
                                 :disabled="isLoading"
                    ></bbn-numeric>
                    <span v-text="'<?=_('of')?>' + ' ' + numPages" style="margin-right: 0.25em"></span>
                    <bbn-button icon="nf nf-fa-angle_right"
                                :notext="true"
                                title="<?=_('Go to the next page')?>"
                                :disabled="isLoading || (currentPage == numPages)"
                                @click="currentPage++"
                    ></bbn-button>
                    <bbn-button icon="nf nf-fa-angle_double_right"
                                :notext="true"
                                title="<?=_('Go to the last page')?>"
                                @click="currentPage = numPages"
                                :disabled="isLoading || (currentPage == numPages)"
                    ></bbn-button>
                    <span class="bbn-hmargin">
                      <bbn-dropdown :source="limits"
                                    v-model.number="currentLimit"
                                    @change="currentPage = 1"
                                    :disabled="!!isLoading"
                                    :autosize="true"
                      ></bbn-dropdown>
										  <span><?=_('items per page')?></span>
									</span>
                  </div>
                  <div class="bbn-block" style="float: right">
									<span v-if="pageable"
                        v-text="'<?=_('Display items')?> ' + (start+1) + '-' + (start + currentLimit > total ? total : start + currentLimit) + ' <?=_('of')?> ' + total"
                  ></span>
                    <span v-else
                          v-text="total ? '<?=_('Total')?>: ' + total + ' <?=_('items')?>' : '<?=_('No item')?>'"
                    ></span>
                    &nbsp;
                    <bbn-button v-if="isAjax"
                                title="<?=_('Refresh')?>"
                                @click="updateData"
                                icon="nf nf-fa-refresh"
                    ></bbn-button>
                  </div>
                </div>
              </appui-notes-forum-pager>
            </div>
          </div>
        </appui-notes-forum-topic>
			</bbn-scroll>
		</div>
		<!-- Footer -->
		<div class="appui-notes-forum-pager bbn-widget"
         v-if="pageable || filterable || isAjax"
    >
      <div class="bbn-block"
           v-if="pageable"
      >
        <bbn-button icon="nf nf-fa-angle_double_left"
                    :notext="true"
                    title="<?=_('Go to the first page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage = 1"
        ></bbn-button>
        <bbn-button icon="nf nf-fa-angle_left"
                    :notext="true"
                    title="<?=_('Go to the previous page')?>"
                    :disabled="isLoading || (currentPage == 1)"
                    @click="currentPage--"
        ></bbn-button>
        <span><?=_('Page')?></span>
        <bbn-numeric v-if="currentData.length"
                     v-model="currentPage"
                     :min="1"
                     :max="numPages"
                     :disabled="isLoading"
                     class="bbn-narrower bbn-right-sspace"
        ></bbn-numeric>
        <span v-text="'<?=_('of')?> ' + numPages" style="margin-right: 0.25em"></span>
        <bbn-button icon="nf nf-fa-angle_right"
                    :notext="true"
                    title="<?=_('Go to the next page')?>"
                    :disabled="isLoading || (currentPage == numPages)"
                    @click="currentPage++"
        ></bbn-button>
        <bbn-button icon="nf nf-fa-angle_double_right"
                    :notext="true"
                    title="<?=_('Go to the last page')?>"
                    @click="currentPage = numPages"
                    :disabled="isLoading || (currentPage == numPages)"
        ></bbn-button>
        <span class="bbn-hmargin">
          <bbn-dropdown :source="limits"
                        v-model.number="currentLimit"
                        @change="currentPage = 1"
                        :disabled="!!isLoading"
                        :autosize="true"
          ></bbn-dropdown>
          <span><?=_('items per page')?></span>
        </span>
      </div>
      <div class="bbn-block" style="float: right">
        <span v-if="pageable"
              v-text="'<?=_('Display items')?> ' + (start+1) + '-' + (start + currentLimit > total ? total : start + currentLimit) + ' <?=_('of')?> ' + total"
        ></span>
        <span v-else
              v-text="total ? '<?=_('Total')?> : ' + total + ' <?=_('items')?>' : '<?=_('No item')?>'"
        ></span>
        &nbsp;
        <bbn-button v-if="isAjax"
                    title="<?=_('Refresh')?>"
                    @click="updateData"
                    icon="nf nf-fa-refresh"
        ></bbn-button>
      </div>
    </div>
	</div>
</div>