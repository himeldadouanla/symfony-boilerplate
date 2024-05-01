import { gql } from 'graphql-request'
import { EmpFragment } from '@/graphql/employees/emp.fragment'

export const EmployeeQuery = gql`
  query employee($id: String!) {
    employee(employee: { id: $id }) {
      ...EmpFragment
    }
  }
  ${EmpFragment}
`
