import { gql } from 'graphql-request'
import { EmpFragment } from '@/graphql/employees/emp.fragment'

export const EmployeesQuery = gql`
  query employees($search: String, $sortOrder: SortOrder, $offset: Int!) {
    employees(search: $search, sortOrder: $sortOrder)
  }
  ${EmpFragment}
`
