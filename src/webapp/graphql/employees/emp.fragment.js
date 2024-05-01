import { gql } from 'graphql-request'

export const EmpFragment = gql`
  fragment EmpFragment on Employee {
    id
    fullName
    address
    phone
    email
  }
`
