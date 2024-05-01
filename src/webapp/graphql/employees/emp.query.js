import { gql } from 'graphql-request'
import { EmpFragment } from '@/graphql/employees/emp.fragment'

export const EmpQuery = gql`
  query employees(
    $search: String
    $sortOrder: SortOrder
    $limit: Int!
    $offset: Int!
  ) {
    employees(search: $search, sortOrder: $sortOrder) {
      items(limit: $limit, offset: $offset) {
        ...EmpFragment
      }
      count
    }
  }
  ${EmpFragment}
`
