import { gql } from 'graphql-request'
import { EmpFragment } from '@/graphql/employees/emp.fragment'

export const UpdateEmployeeMutation = gql`
  mutation updateEmployee(
    $id: String!
    $fullName: String!
    $address: String!
    $phone: String!
    $email: String!
    $locale: Locale!
  ) {
    updateEmployee(
      employee: { id: $id }
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
