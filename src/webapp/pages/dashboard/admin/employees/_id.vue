<template>
  <div>
    <b-card>
      <b-form @submit.stop.prevent="onSubmit">
        <b-form-row>
          <b-col md="6">
            <b-form-group
              id="input-group-full-name"
              :label="$t('common.employee.full_name.label_required')"
              label-for="input-first-name"
            >
              <b-form-input
                id="input-first-name"
                v-model="form.fullName"
                type="text"
                :placeholder="$t('common.employee.full_name.placeholder')"
                autofocus
                trim
                required
                :state="formState('fullName')"
              />
              <b-form-invalid-feedback :state="formState('fullName')">
                <ErrorsList :errors="formErrors('fullName')" />
              </b-form-invalid-feedback>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              id="input-group-address"
              :label="$t('common.employee.address.label_required')"
              label-for="input-address"
            >
              <b-form-input
                id="input-address"
                v-model="form.address"
                type="text"
                :placeholder="$t('common.employee.address.placeholder')"
                trim
                required
                :state="formState('address')"
              />
              <b-form-invalid-feedback :state="formState('address')">
                <ErrorsList :errors="formErrors('address')" />
              </b-form-invalid-feedback>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              id="input-group-phone"
              :label="$t('common.employee.phone.label_required')"
              label-for="input-phone"
            >
              <b-form-input
                id="input-phone"
                v-model="form.phone"
                type="text"
                :placeholder="$t('common.employee.phone.placeholder')"
                trim
                required
                :state="formState('phone')"
              />
              <b-form-invalid-feedback :state="formState('phone')">
                <ErrorsList :errors="formErrors('phone')" />
              </b-form-invalid-feedback>
            </b-form-group>
          </b-col>
        </b-form-row>
        <b-form-row>
          <b-col md="6">
            <b-form-group
              id="input-group-email"
              :label="$t('common.email.label_required')"
              label-for="input-email"
            >
              <b-form-input
                id="input-email"
                v-model="form.email"
                type="text"
                :placeholder="$t('common.email.placeholder')"
                trim
                required
                :state="formState('email')"
              />
              <b-form-invalid-feedback :state="formState('email')">
                <ErrorsList :errors="formErrors('email')" />
              </b-form-invalid-feedback>
            </b-form-group>
          </b-col>
          <b-col v-if="!selfUpdate">
            <b-form-group
              id="input-group-locale"
              :label="$t('common.employee.locale.label_required')"
              label-for="input-locale"
            >
              <b-form-select
                id="input-locale"
                v-model="form.locale"
                :options="localesAsSelectOptions()"
                required
                :state="formState('locale')"
              ></b-form-select>
              <b-form-invalid-feedback :state="formState('locale')">
                <ErrorsList :errors="formErrors('locale')" />
              </b-form-invalid-feedback>
            </b-form-group>
          </b-col>
        </b-form-row>
        <b-button type="submit" variant="primary">
          {{ $t('common.update') }}
        </b-button>
      </b-form>
    </b-card>
    <b-card v-if="!selfUpdate" class="mt-3" border-variant="danger">
      <ConfirmDelete :on-confirm="onDelete" />
    </b-card>
  </div>
</template>

<script>
import { EmployeeQuery } from '@/graphql/employees/employee.query'
import { UpdateEmployeeMutation } from '@/graphql/employees/update_employee.mutation'
import { Form } from '@/mixins/form'
import { Locales } from '@/mixins/locales'
import { GlobalOverlay } from '@/mixins/global-overlay'
import { Auth } from '@/mixins/auth'
import { Images } from '@/mixins/images'
import { GenericToast } from '@/mixins/generic-toast'
import ErrorsList from '@/components/forms/ErrorsList'
import FilesList from '@/components/forms/FilesList'
import { DeleteEmployeeMutation } from '@/graphql/employees/delete_employee.mutation'
import ConfirmDelete from '@/components/forms/ConfirmDelete'

export default {
  // eslint-disable-next-line vue/no-unused-components
  components: { ConfirmDelete, FilesList, ErrorsList },
  mixins: [Form, Locales, GlobalOverlay, Auth, Images, GenericToast],
  layout: 'dashboard',
  async asyncData(context) {
    try {
      const result = await context.app.$graphql.request(EmployeeQuery, {
        id: context.params.id,
      })

      return {
        form: {
          fullName: result.employee.fullName,
          address: result.employee.address,
          phone: result.employee.phone,
          email: result.employee.email,
          locale: result.employee.locale.toUpperCase(),
        },
      }
    } catch (e) {
      context.error(e)
    }
  },
  data() {
    return {
      form: {
        fullName: '',
        address: '',
        phone: '',
        email: '',
        locale: null,
      },
    }
  },
  computed: {
    selfUpdate() {
      return this.employee.id === this.$route.params.id
    },
  },
  methods: {
    async onSubmit() {
      this.resetFormErrors()
      this.displayGlobalOverlay()

      try {
        const result = await this.$graphql.request(UpdateEmployeeMutation, {
          id: this.$route.params.id,
          fullName: this.form.fullName,
          address: this.form.address,
          phone: this.form.phone,
          email: this.form.email,
          locale: this.selfUpdate
            ? this.employee.locale.toUpperCase()
            : this.form.locale,
        })
        this.genericSuccessToast()

        // Same employee as authenticated one.
        if (this.selfUpdate) {
          this.setEmployee(result.updateEmployee)
        }
      } catch (e) {
        this.hydrateFormErrors(e)
      } finally {
        this.hideGlobalOverlay()
      }
    },
    async onDelete() {
      this.displayGlobalOverlay()

      try {
        await this.$graphql.request(DeleteEmployeeMutation, {
          id: this.$route.params.id,
        })

        this.genericSuccessToast()
        this.$router.push(
          this.localePath({ name: 'dashboard-admin-employees' })
        )
      } catch (e) {
        this.$nuxt.error(e)
      } finally {
        this.hideGlobalOverlay()
      }
    },
  },
}
</script>
