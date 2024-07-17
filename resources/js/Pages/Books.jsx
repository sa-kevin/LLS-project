import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import BookList from '../Components/Book/BookList';
import { route } from 'ziggy-js';
import { useEffect } from 'react';

export default function Book({ auth, books, search }) {
  const { data, setData, get, processing } = useForm({
    search: search || '',
  });

  const handleSearch = (e) => {
    e.preventDefault();
    get(route('books.index', { search: data.search }), { preserveState: true });
  };

  useEffect(() => {
    const debounce = setTimeout(() => {
      if (data.search !== search) {
        get(route('books.index', { search: data.search }), {
          preserveState: true,
        });
      }
    }, 300);
    return () => clearTimeout(debounce);
  }, [data.search]);

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          List of Books
        </h2>
      }
    >
      <Head title="Books" />

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <form onSubmit={handleSearch} className="mb-4">
                <input
                  type="text"
                  value={data.search}
                  onChange={(e) => setData('search', e.target.value)}
                  placeholder="Search books..."
                  className="w-full px-4 py-2 border rounded-md"
                />
              </form>
              <BookList books={books} />
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
