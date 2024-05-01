<template>
  <div>
    <b-card>
      <b-form inline @submit.stop.prevent>
        <label class="sr-only" for="inline-form-input-search">{{
          $t('common.search')
        }}</label>
        <b-input
          id="inline-form-input-search"
          v-model="filters.search"
          class="mb-2 mr-sm-2 mb-sm-0"
          style="min-width: 50%"
          type="text"
          :placeholder="$t('common.search')"
          autofocus
          trim
          :debounce="debounce"
          @update="onSearch"
        ></b-input>
        <div class="m-auto mr-sm-0 ml-sm-auto">
          <b-button
            variant="primary"
            :to="localePath({ name: 'dashboard-admin-employees-create' })"
            >{{ $t('common.create') }}</b-button
          >
          <b-button
            variant="outline-primary"
            :href="$config.apiURL + 'employees/xlsx' + rawQueryParameters()"
            >{{ $t('common.export') }}</b-button
          >
        </div>
      </b-form>
    </b-card>
    <b-card class="mt-3">
      <b-table
        hover
        :responsive="true"
        :no-local-sorting="true"
        :sort-by="boostrapTableSortBy"
        :sort-desc="isDesc"
        :items="items"
        :fields="fields"
        :busy="isLoading"
        @sort-changed="onSort"
      >
        <template #cell(actions)="data">
          <b-button
            size="sm"
            variant="primary"
            :aria-label="$t('common.edit')"
            :to="
              localePath({
                name: 'dashboard-admin-employees-id',
                params: { id: data.item.id },
              })
            "
          >
            <b-icon icon="pencil"></b-icon>
          </b-button>
        </template>
        <template #table-busy>
          <div class="text-center my-2">
            <b-spinner class="align-middle" variant="primary"></b-spinner>
          </div>
        </template>
      </b-table>
      <b-pagination
        v-model="currentPage"
        :per-page="itemsPerPage"
        :total-rows="count"
        align="center"
        @change="onPaginate"
        @click.native="$scrollToTop"
      />
    </b-card>
  </div>
</template>

<script>
import { Form } from '@/mixins/form'
import { List, defaultItemsPerPage, calculateOffset } from '@/mixins/list'
import {
  FULL_NAME,
  ADDRESS,
  PHONE,
  EMAIL,
} from '@/enums/filters/employees-sort-by'
import { EmpQuery } from '@/graphql/employees/emp.query'

export default {
  mixins: [Form, List],
  layout: 'dashboard',
  async asyncData(context) {
    try {
      const result = await context.app.$graphql.request(EmpQuery, {
        search: context.route.query.search || '',
        // sortBy: context.route.query.sortBy || null,
        sortOrder: context.route.query.sortOrder || null,
        limit: defaultItemsPerPage,
        offset: calculateOffset(
          context.route.query.page || 1,
          defaultItemsPerPage
        ),
      })
      return {
        items: result.employees.items,
        count: result.employees.count,
      }
    } catch (e) {
      context.error(e)
    }
  },
  data() {
    return {
      filters: {
        search: this.$route.query.search || '',
      },
      fields: [
        {
          key: 'fullName',
          label: this.$t('common.employee.full_name.label'),
          sortable: true,
        },
        {
          key: 'address',
          label: this.$t('common.employee.address.label'),
          sortable: true,
        },
        {
          key: 'phone',
          label: this.$t('common.employee.phone.label'),
          sortable: true,
        },
        { key: 'email', label: this.$t('common.email.label'), sortable: true },
        {
          key: 'locale',
          label: this.$t('common.employee.locale.label'),
          sortable: false,
        },
        {
          key: 'actions',
          label: this.$t('common.list.actions'),
          sortable: false,
        },
      ],
      sortByMap: {
        fullName: FULL_NAME,
        address: ADDRESS,
        phone: PHONE,
        email: EMAIL,
      },
    }
  },
  methods: {
    async doSearch() {
      this.isLoading = true
      this.updateRouter()
      try {
        const result = await this.$graphql.request(EmpQuery, {
          search: this.filters.search,
          // sortBy: this.sortBy,
          sortOrder: this.sortOrder,
          limit: this.itemsPerPage,
          offset: this.offset,
        })
        this.items = result.employees.items
        this.count = result.employees.count
        this.isLoading = false
      } catch (e) {
        this.$nuxt.error(e)
      }
    },
  },
}
</script>
