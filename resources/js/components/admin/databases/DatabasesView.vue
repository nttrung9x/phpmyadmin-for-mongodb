<!--
  - PhpMongoAdmin (www.phpmongoadmin.com) by Masterforms Mobile & Web (MFMAW)
  - @version      DatabasesView.vue 1001 6/8/20, 8:58 pm  Gilbert Rehling $
  - @package      PhpMongoAdmin\resources
  - @subpackage   DatabasesView.vue
  - @link         https://github.com/php-mongo/admin PHP MongoDB Admin
  - @copyright    Copyright (c) 2020. Gilbert Rehling of MMFAW. All rights reserved. (www.mfmaw.com)
  - @licence      PhpMongoAdmin is an Open Source Project released under the GNU GPLv3 license model.
  - @author       Gilbert Rehling:  gilbert@phpmongoadmin.com (www.gilbert-rehling.com)
  -  php-mongo-admin - License conditions:
  -  Contributions to our suggestion box are welcome: https://phpmongotools.com/suggestions
  -  This web application is available as Free Software and has no implied warranty or guarantee of usability.
  -  See licence.txt for the complete licensing outline.
  -  See https://www.gnu.org/licenses/license-list.html for information on GNU General Public License v3.0
  -  See COPYRIGHT.php for copyright notices and further details.
  -->

<style lang="scss">
    @import '~@/abstracts/_variables.scss';
    .pma-databases-view {
        float: left;
        width: auto;

        .database-inner {
            form {
                margin-bottom: 10px;
            }
            p {
                margin-bottom: 0;
                padding-left: 1px;

                input {
                    line-height: 1.65;
                    margin-top: 1px;
                    vertical-align: top ;
                }

                .button {
                    margin: 0;
                    padding: 0.5em 1em;
                }
            }
            p.drop {
                padding-left: 5px;

                label {
                    display: inline-block;
                }

                span {
                    vertical-align: middle;
                }

                input {
                    margin-right: 0.1rem;
                    vertical-align: sub;
                }

                .pma-link {
                    font-size: 1.1rem;
                    margin-right: 20px;
                    vertical-align: sub;
                }

                button {
                    padding: 0.3em 0.5em;
                }
            }
            table {
                border: 1px solid $infoColor;
                border-radius: 5px;
                box-shadow: 2px 2px 5px $cccColor;
            }
            table th {
                background-color: $tableHeaderBg;
                color: $white;
                font-size: 1.2rem;
                padding: 4px;
            }
            table .info {
                background-color: $infoBgColor;
                padding: 4px 4px 4px 8px;
            }
            table.bordered th.bb {
                border-bottom: 1px solid $cccColor;
            }
            table.bordered th.rb {
                border-right: 1px solid $infoColor;
            }
            table.bordered td {
                border-bottom: 1px solid $cccColor;
                text-align: left;
            }
            table.bordered td.rb {
                border-right: 1px solid $infoColor;
            }
            table.bordered td.text-center {
                text-align: center !important;
            }
            table td input {
                margin: 3px 0 0 0;
            }
        }
    }
</style>

<template>
    <div id="pma-databases-view" class="pma-databases-view align-left" v-show="show">
        <div class="database-inner">
            <div class="pma-create-db">
                <form id="db-new" v-if="canUserCreate">
                    <label>
                        <span class="pma-link" v-text="showLanguage('databases', 'createDb')" v-on:click="showCreateField"></span>
                        <p v-show="createField">
                            <input v-model="newDb" :placeholder="showLanguage('databases', 'dbName')" />
                            <button class="button" v-on:click="createDatabase($event)" v-text="showLanguage('databases', 'buttonCreate')"></button>
                        </p>
                        <p class="form-error" v-show="errorText"></p>
                    </label>
                </form>
            </div>
            <form id="db-list">
                <table class="bordered unstriped" v-if="getDatabases.length >= 1">
                    <tr>
                        <th v-text="showLanguage('databases', 'databases')" colspan="8" class="bb"></th>
                    </tr>
                    <tr>
                        <th class="rb">&nbsp;</th>
                        <th v-text="showLanguage('databases', 'name')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'size')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'storageSize')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'dataSize')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'indexSize')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'collections')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'objects')"></th>
                    </tr>
                    <database-card v-for="(db, index) in getDatabases" :key="index" v-bind:db="db"></database-card>
                </table>
                <table class="bordered unstriped" v-if="hasList">
                    <tr>
                        <th v-text="showLanguage('databases', 'databases')" colspan="3" class="bb"></th>
                    </tr>
                    <tr>
                        <th v-text="showLanguage('databases', 'name')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'sizeOnDisk')" class="rb"></th>
                        <th v-text="showLanguage('databases', 'isEmpty')"></th>
                    </tr>
                    <database-list v-for="(db, index) in list" :key="index" v-bind:db="db"></database-list>
                </table>
                <p class="drop" v-if="canUserDrop">
                    <img src="img/arrow-ltr.png" />
                    <label><input type="checkbox" v-model="deleteAll" /> <span class="pma-link" v-text="showLanguage('databases', 'checkAll')"></span></label>
                    <span v-text="showLanguage('databases', 'withSelected')"></span>
                    <button class="button" v-on:click="deleteDatabases($event)" v-text="showLanguage('databases', 'buttonDrop')"></button>
                </p>
                <p class="text-info" v-if="userHasNoRoles" v-html="showLanguage('global', 'noRoles')"></p>
            </form>
        </div>
    </div>
</template>

<script>
    /*
    *   Import the Event bus
    */
    import { EventBus } from '../../../event-bus.js';

    /*
    *   Import components for the Databases View
    */
    import DatabaseCard from "./DatabaseCard";
    import DatabaseList from "./DatabaseList";

    export default {
        /*
        *   Register the components to be used by the home page.
        */
        components: {
            DatabaseCard,
            DatabaseList
        },

        /*
        *   Data required for this component
        */
        data() {
            return {
                checked: [],
                createField: false,
                deleteAll: null,
                errorText: false,
                index: 0,
                limit: 55,
                list: null,
                newDb: null,
                show: false,
            }
        },

        /*
        *   Defines the computed properties on the component.
        */
        computed: {
            /*
            *  fetch the databases for iteration in the template
            */
            getDatabases() {
                return this.$store.getters.getDatabases
            },

            canUserWrite() {
                return this.$store.getters.getCanUserWriteDatabase
            },

            canUserCreate() {
                return this.$store.getters.getCanUserCreateDatabase
            },

            canUserDrop() {
                return this.$store.getters.getCanUserDropDatabase
            },

            deleteAllDatabases() {
                return this.deleteAll
            },

            hasList() {
                return this.list && this.list.length >= 1
            },

            userHasNoRoles() {
                return this.$store.getters.getCanUserWriteDatabase === false &&
                    this.$store.getters.canUserAdminUsers === false
            }
        },

        /*
        *   Define methods for the server component
        */
        methods: {
            /*
            *   Calls the Translation and Language service
            */
            showLanguage( context, key ) {
                return this.$store.getters.getLanguageString( context, key )
            },

            /*
            *   Display the DB creation field and button
            */
            showCreateField() {
                this.createField = !this.createField
            },

            /*
            *   Handle ethe Create Database function
            */
            createDatabase(event) {
                event.preventDefault();
                if (this.newDb) {
                    let db = this.newDb;
                    this.$store.dispatch( 'createDatabase', db );
                    this.index = 0;
                    this.checkNewDatabase()
                }
            },

            /*
            *   Handles the monitoring of the DB creation process
            */
            checkNewDatabase() {
                let status = this.$store.getters.getCreateDatabaseStatus;
                if (status === 1 && this.index < this.limit) {
                    this.index += 1;
                    setTimeout(() => {
                        this.checkNewDatabase()
                    }, 100)
                }
                if (status === 2) {
                    this.newDb = null;
                    this.createField = false
                }
                if (status === 3) {
                    // error
                    this.errorText = "Error creating database: " + this.newDb
                }
            },

            /*
            *   Handles the database deletions - one or many
            */
            deleteDatabases(event) {
                event.preventDefault();
                this.$store.dispatch( 'deleteDatabase', this.checked );
                this.index = 0;
                this.handleDeleteDatabase()
            },

            /*
            *   Handles the monitoring of the DB creation process
            */
            handleDeleteDatabase() {
                let status = this.$store.getters.getDeleteDatabaseStatus;
                if (status === 1 && this.index < this.limit) {
                    setTimeout(() => {
                        this.handleDeleteDatabase()
                    }, 100)
                }
                if (status === 2) {
                    this.checked = [];
                    EventBus.$emit('uncheck-all-databases')
                }
                if (status === 3) {
                    // error
                    this.errorText = "Error deleting database: " + this.checked
                }
            },

            /*
            *   Check and uncheck all databases for the Check all function
            */
            checkAllDbs() {
                if (this.deleteAll === true) {
                    EventBus.$emit('check-all-databases')
                }
                else {
                    EventBus.$emit('uncheck-all-databases')
                }
            },

            removeDbFromArray( db ) {
              let dbs = this.checked;
              let checked = [];
              dbs.forEach(function(value) {
                  if (value !== db) {
                      checked.push(value)
                  }
              });
              this.checked = checked
            },

            handleList() {
                let dbs = this.$store.getters.getDatabases,
                    read = this.$store.getters.getCanUserReadDatabase;
                if (read === false && !dbs || dbs.length === 0) {
                    this.list = this.$store.getters.getDatabaseList
                }
            },

            /*
            *   Show component
            */
            showComponent() {
                this.show = true
            },

            /*
            *   Hide component
            */
            hideComponent() {
                this.show = false
            }
        },

        /*
        *    get on ur bikes and ride !!
        */
        mounted() {
            setTimeout(() => {
                this.handleList()
            }, 1000)
            /*
            *    Hide this component
            */
            EventBus.$on('hide-panels', ( ) => {
                this.hideComponent()
            });

            /*
            *    Show this component
            */
            EventBus.$on('show-databases', () => {
                this.showComponent()
            });

            /*
            *   Listen for child check box selected and add to array
            */
            EventBus.$on('track-checked-db', ( db ) => {
                this.checked.push(db)
            });

            /*
            *   Listen for child check box un-selected and remove from array
            */
            EventBus.$on('untrack-checked-db', ( db ) => {
                this.removeDbFromArray(db)
            });
        },

        watch: {
            deleteAllDatabases() {
                this.checkAllDbs()
            },
        }
    }
</script>
