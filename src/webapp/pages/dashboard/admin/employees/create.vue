<template>
  <b-card>
    <b-form @submit.stop.prevent="onSubmit">
      <b-form-row>
        <b-col md="6">
          <b-form-group
            id="input-group full-name"
            :label="$t('common.employee.full_name.label_required')"
            label-for="input-full-name"
          >
            <b-form-input
              id="input-full-name"
              v-model="form.fullName"
              type="string"
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
              type="string"
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
        <b-col>
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
        {{ $t('common.create') }}
      </b-button>
    </b-form>
  </b-card>
</template>

<script>
import FilesList from '@/components/forms/FilesList'
import ErrorsList from '@/components/forms/ErrorsList'
import { Form } from '@/mixins/form'
import { Locales } from '@/mixins/locales'
import { GlobalOverlay } from '@/mixins/global-overlay'
import { GenericToast } from '@/mixins/generic-toast'
import { CreateEmployeeMutation } from '@/graphql/employees/create_employee.mutation'

export default {
  // eslint-disable-next-line vue/no-unused-components
  components: { ErrorsList, FilesList },
  mixins: [Form, Locales, GlobalOverlay, GenericToast],
  layout: 'dashboard',
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
  methods: {
    async onSubmit() {
      this.resetFormErrors()
      this.displayGlobalOverlay()

      try {
        const result = await this.$graphql.request(CreateEmployeeMutation, {
          fullName: this.form.fullName,
          address: this.form.address,
          phone: this.form.phone,
          email: this.form.email,
          locale: this.form.locale,
        })

        this.genericSuccessToast()

        this.$router.push(
          this.localePath({
            name: 'dashboard-admin-employees-id',
            params: { id: result.createEmployee.id },
          })
        )
      } catch (e) {
        this.hydrateFormErrors(e)
      } finally {
        this.hideGlobalOverlay()
      }
    },
  },
}
</script>
