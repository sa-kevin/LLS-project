import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import BookList from '../Components/Book/BookList';

export default function Book({ auth, books }) {
  console.log('Books data:', books);
  console.log('Books type:', typeof books);
  console.log('Is array:', Array.isArray(books));

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-2xl text-gray-800 leading-tight">
          List of Books
        </h2>
      }
    >
      <Head title="Books" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <BookList books={books} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
