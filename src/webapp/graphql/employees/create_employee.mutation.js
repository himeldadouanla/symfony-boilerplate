import { gql } from 'graphql-request'
import { EmpFragment } from '@/graphql/employees/emp.fragment'

export const CreateEmployeeMutation = gql`
  mutation createEmployee(
    $fullName: String!
    $address: String!
    $phone: String!
    $email: String!
    $locale: Locale!
  ) {
    createEmployee(
      fullName: $fullName
      address: $address
      phone: $phone
      email: $email
      locale: $locale
    ) {
      ...EmpFragment
    }
  }
  ${EmpFragment}
`
